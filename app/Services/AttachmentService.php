<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 24/04/2021
 * Time: 00:14
 */

namespace App\Services;

use App\Models\Attachment;
use App\Repositories\AttachmentRepository;
use Illuminate\Support\Facades\Storage;

class AttachmentService
{
    /**
     * @var AttachmentRepository
     */
    private $attachmentRepository;

    /**
     * AttachmentService constructor.
     *
     * @param AttachmentRepository $attachmentRepository
     */
    public function __construct(AttachmentRepository $attachmentRepository)
    {
        $this->attachmentRepository = $attachmentRepository;
    }

    public function storeOfferAttachment(array $attachment, int $offerId)
    {
        try {
            $decodedContent = base64_decode($attachment['content']);

            $path = Storage::disk('offers')->put($attachment['name'], $decodedContent);
            $attachment = array_merge(['path' => $path], $attachment);
            $savedAttachment = $this->attachmentRepository->storeAttachments($attachment);

            if ($savedAttachment) {
                return $this->attachmentRepository->linkOfferAttachment(
                    [
                        'offerId' => $offerId,
                        'attachmentId' => $savedAttachment->id,
                    ]
                );
            }

        } catch (\Exception $e) {
            clock()->info(
                'BŁĄD POCZAS DODAWANIA ZAŁĄCZNIKA DO OFERTY',
                [
                    'method' => 'AttachmentService::storeOfferAttachment',
                    'dump' => (array)$e,
                ]
            );
            return false;
        }
    }

    public function storeAgreementAttachments(array $attachments, int $agreementId)
    {
        try {
            $result = [];

            foreach ($attachments as $attachment) {
                $path = Storage::disk('agreements')->put($attachment['name'], base64_encode($attachment['content']));
                $attachment['path'] = $path;
                $savedAttachment = $this->attachmentRepository->storeAttachments($attachment);

                if ($savedAttachment) {
                    $result[$attachment['name']] = $savedAttachment !== null;
                    $this->attachmentRepository->linkAgreementAttachment($savedAttachment->id, $agreementId);
                }
            }

            return $result;
        } catch (\Exception $e) {
            clock()->info(
                'BŁĄD POCZAS DODAWANIA ZAŁĄCZNIKA DO UMOWY',
                [
                    'method' => 'AttachmentService::storeAgreementAttachments',
                    'dump' => (array)$e,
                ]
            );
        }
    }

    public function storeAttachments(string $name, string $mime, string $path, int $userId, string $description = null)
    {
        $attachment = new Attachment();
        $attachment->name = $name;
        $attachment->mime = $mime;
        $attachment->path = $path;
        $attachment->user_id = $userId;
        $attachment->description = $description;
        $attachment->freshTimestamp();

        if ($attachment->save()) {
            return $attachment;
        }

        return null;
    }
}
