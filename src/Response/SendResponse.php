<?php

declare(strict_types=1);

namespace Kerox\Messenger\Response;

use Psr\Http\Message\ResponseInterface;

class SendResponse extends AbstractResponse
{
    private const RECIPIENT_ID = 'recipient_id';
    private const MESSAGE_ID = 'message_id';
    private const ATTACHMENT_ID = 'attachment_id';

    private const ERROR = 'error';
    private const ERROR_MESSAGE = 'message';
    private const ERROR_TYPE = 'type';
    private const ERROR_CODE = 'code';
    private const ERROR_SUBCODE = 'error_subcode';
    private const ERROR_FBTRACE_ID = 'fbtrace_id';

    /**
     * @var null|string
     */
    protected $recipientId;

    /**
     * @var null|string
     */
    protected $messageId;

    /**
     * @var null|string
     */
    protected $attachmentId;

    /**
     * @var null|string
     */
    protected $errorMessage;

    /**
     * @var null|string
     */
    protected $errorType;

    /**
     * @var null|int
     */
    protected $errorCode;

    /**
     * @var null|int
     */
    protected $errorSubcode;

    /**
     * @var null|string
     */
    protected $errorFbtraceId;

    /**
     * Send constructor.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response);
    }

    /**
     * @param array $response
     */
    protected function parseResponse(array $response): void
    {
        if (!$this->hasError($response)) {
            $this->setRecipientId($response);
            $this->setMessageId($response);
            $this->setAttachmentId($response);
        }
    }

    /**
     * @param array $response
     *
     * @return bool
     */
    private function hasError(array $response): bool
    {
        if (isset($response[self::ERROR])) {
            $this->setErrorMessage($response[self::ERROR]);
            $this->setErrorType($response[self::ERROR]);
            $this->setErrorCode($response[self::ERROR]);
            $this->setErrorSubcode($response[self::ERROR]);
            $this->setErrorFbtraceId($response[self::ERROR]);

            return true;
        }

        return false;
    }

    /**
     * @return null|string
     */
    public function getRecipientId(): ?string
    {
        return $this->recipientId;
    }

    /**
     * @param array $response
     */
    private function setRecipientId(array $response): void
    {
        if (isset($response[self::RECIPIENT_ID])) {
            $this->recipientId = $response[self::RECIPIENT_ID];
        }
    }

    /**
     * @return null|string
     */
    public function getMessageId(): ?string
    {
        return $this->messageId;
    }

    /**
     * @param array $response
     */
    private function setMessageId(array $response): void
    {
        if (isset($response[self::MESSAGE_ID])) {
            $this->messageId = $response[self::MESSAGE_ID];
        }
    }

    /**
     * @return null|string
     */
    public function getAttachmentId(): ?string
    {
        return $this->attachmentId;
    }

    /**
     * @param array $response
     */
    private function setAttachmentId(array $response): void
    {
        if (isset($response[self::ATTACHMENT_ID])) {
            $this->attachmentId = $response[self::ATTACHMENT_ID];
        }
    }

    /**
     * @return null|string
     */
    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    /**
     * @param array $error
     */
    private function setErrorMessage(array $error): void
    {
        if (isset($error[self::ERROR_MESSAGE])) {
            $this->errorMessage = $error[self::ERROR_MESSAGE];
        }
    }

    /**
     * @return null|string
     */
    public function getErrorType(): ?string
    {
        return $this->errorType;
    }

    /**
     * @param array $error
     */
    private function setErrorType(array $error): void
    {
        if (isset($error[self::ERROR_TYPE])) {
            $this->errorType = $error[self::ERROR_TYPE];
        }
    }

    /**
     * @return null|int
     */
    public function getErrorCode(): ?int
    {
        return $this->errorCode;
    }

    /**
     * @param array $error
     */
    private function setErrorCode(array $error): void
    {
        if (isset($error[self::ERROR_CODE])) {
            $this->errorCode = $error[self::ERROR_CODE];
        }
    }

    /**
     * @return null|int
     */
    public function getErrorSubcode(): ?int
    {
        return $this->errorSubcode;
    }

    /**
     * @param array $error
     */
    private function setErrorSubcode(array $error): void
    {
        if (isset($error[self::ERROR_SUBCODE])) {
            $this->errorSubcode = $error[self::ERROR_SUBCODE];
        }
    }

    /**
     * @return null|string
     */
    public function getErrorFbtraceId(): ?string
    {
        return $this->errorFbtraceId;
    }

    /**
     * @param array $error
     */
    private function setErrorFbtraceId(array $error): void
    {
        if (isset($error[self::ERROR_FBTRACE_ID])) {
            $this->errorFbtraceId = $error[self::ERROR_FBTRACE_ID];
        }
    }
}
