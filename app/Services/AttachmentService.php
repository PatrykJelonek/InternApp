<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 24/04/2021
 * Time: 00:14
 */

namespace App\Services;

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
                return $this->attachmentRepository->linkOfferAttachments(
                    [
                        'offerId' => $offerId,
                        'attachmentId' => $savedAttachment->id,
                    ]
                );
            }

        } catch (\Exception $e) {
            clock()->info(
                'BŁĄD POCZAS DODAWANIA ZAŁĄCZNIKA DO PRAKTYKI',
                [
                    'method' => 'AttachmentService::storeOfferAttachment',
                    'dump' => (array)$e,
                ]
            );
            return false;
        }
    }
}
