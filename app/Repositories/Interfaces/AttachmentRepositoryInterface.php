<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 22/04/2021
 * Time: 21:42
 */

namespace App\Repositories\Interfaces;

interface AttachmentRepositoryInterface
{
    public function storeAttachments(array $data);

    public function linkOfferAttachment(array $data);

    public function linkAgreementAttachment(int $agreementId, int $attachmentId);
}
