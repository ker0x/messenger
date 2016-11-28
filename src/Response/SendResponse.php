<?php
namespace Kerox\Messenger\Response;

use Psr\Http\Message\ResponseInterface;

class SendResponse extends AbstractResponse
{

    const RECIPIENT_ID = 'recipient_id';
    const MESSAGE_ID = 'message_id';
    const ATTACHMENT_ID = 'attachment_id';

    const ERROR = 'error';
    const ERROR_MESSAGE = 'message';
    const ERROR_TYPE = 'type';
    const ERROR_CODE = 'code';
    const ERROR_SUBCODE = 'error_subcode';
    const ERROR_FBTRACE_ID = 'fbtrace_id';

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
     * SendResponse constructor.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response);
    }

    /**
     * @param array $response
     * @return void
     */
    protected function parseResponse(array $response)
    {
        if (!$this->hasError($response)) {
            $this->setRecipientId($response);
            $this->setMessageId($response);
            $this->setAttachmentId($response);
        }
    }

    /**
     * @param array $response
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
    public function getRecipientId()
    {
        return $this->recipientId;
    }

    /**
     * @param array $response
     * @return void
     */
    private function setRecipientId(array $response)
    {
        if (isset($response[self::RECIPIENT_ID])) {
            $this->recipientId = $response[self::RECIPIENT_ID];
        }
    }

    /**
     * @return null|string
     */
    public function getMessageId()
    {
        return $this->messageId;
    }

    /**
     * @param array $response
     * @return void
     */
    private function setMessageId(array $response)
    {
        if (isset($response[self::MESSAGE_ID])) {
            $this->messageId = $response[self::MESSAGE_ID];
        }
    }

    /**
     * @return null|string
     */
    public function getAttachmentId()
    {
        return $this->attachmentId;
    }

    /**
     * @param array $response
     * @return void
     */
    private function setAttachmentId(array $response)
    {
        if (isset($response[self::ATTACHMENT_ID])) {
            $this->attachmentId = $response[self::ATTACHMENT_ID];
        }
    }

    /**
     * @return null|string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * @param array $error
     * @return void
     */
    private function setErrorMessage(array $error)
    {
        if (isset($error[self::ERROR_MESSAGE])) {
            $this->errorMessage = $error[self::ERROR_MESSAGE];
        }
    }

    /**
     * @return null|string
     */
    public function getErrorType()
    {
        return $this->errorType;
    }

    /**
     * @param array $error
     * @return void
     */
    private function setErrorType(array $error)
    {
        if (isset($error[self::ERROR_TYPE])) {
            $this->errorType = $error[self::ERROR_TYPE];
        }
    }

    /**
     * @return int|null
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @param array $error
     * @return void
     */
    private function setErrorCode(array $error)
    {
        if (isset($error[self::ERROR_CODE])) {
            $this->errorCode = $error[self::ERROR_CODE];
        }
    }

    /**
     * @return int|null
     */
    public function getErrorSubcode()
    {
        return $this->errorSubcode;
    }

    /**
     * @param array $error
     * @return void
     */
    private function setErrorSubcode(array $error)
    {
        if (isset($error[self::ERROR_SUBCODE])) {
            $this->errorSubcode = $error[self::ERROR_SUBCODE];
        }
    }

    /**
     * @return null|string
     */
    public function getErrorFbtraceId()
    {
        return $this->errorFbtraceId;
    }

    /**
     * @param array $error
     * @return void
     */
    private function setErrorFbtraceId(array $error)
    {
        if (isset($error[self::ERROR_FBTRACE_ID])) {
            $this->errorFbtraceId = $error[self::ERROR_FBTRACE_ID];
        }
    }
}
