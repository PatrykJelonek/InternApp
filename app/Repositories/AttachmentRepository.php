<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 22/04/2021
 * Time: 21:44
 */

namespace App\Repositories;

use App\Models\AgreementAttachment;
use App\Models\Attachment;
use App\Models\OfferAttachment;
use App\Repositories\Interfaces\AttachmentRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttachmentRepository implements AttachmentRepositoryInterface
{

    public function storeAttachments(array $data): ?Attachment
    {
        $attachment = new Attachment();
        $attachment->name = $data['name'];
        $attachment->description = $data['description'] ?? null;
        $attachment->mime = $data['mime'];
        $attachment->path = $data['path'];
        $attachment->user_id = $data['userId'] ?? Auth::id();
        $attachment->freshTimestamp();

        if ($attachment->save()) {
            return $attachment;
        }

        return null;
    }

    public function linkOfferAttachment(array $data): ?OfferAttachment
    {
        $offerAttachment = new OfferAttachment();
        $offerAttachment->offer_id = $data['offerId'];
        $offerAttachment->attachment_id = $data['attachmentId'];
        $offerAttachment->freshTimestamp();

        if ($offerAttachment->save()) {
            return $offerAttachment;
        }

        return null;
    }

    public function linkAgreementAttachment(int $agreementId, int $attachmentId)
    {
        $agreementAttachment = new AgreementAttachment();
        $agreementAttachment->agreement_id = $agreementId;
        $agreementAttachment->attachment_id = $attachmentId;
        $agreementAttachment->freshTimestamp();

        if ($agreementAttachment->save()) {
            return $agreementAttachment;
        }

        return null;
    }
}
