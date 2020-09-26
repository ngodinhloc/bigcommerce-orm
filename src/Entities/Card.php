<?php
declare(strict_types=1);

namespace Bigcommerce\ORM\Entities;

use Bigcommerce\ORM\Annotations as BC;

/**
 * Class PaymentCard
 * @package Bigcommerce\ORM\Entities
 * @BC\Resource(name="PaymentCard")
 */
class Card extends AbstractInstrument
{
    /**
     * @var string|null
     * @BC\Field(name="type", required=true)
     */
    protected $type;

    /**
     * @var string|null
     * @BC\Field(name="cardholder_name", required=true)
     */
    protected $cardholderName;

    /**
     * @var string|null
     * @BC\Field(name="number", required=true)
     */
    protected $number;

    /**
     * @var int|null
     * @BC\Field(name="expiry_month", required=true)
     */
    protected $expiryMonth;

    /**
     * @var int|null
     * @BC\Field(name="expiry_year", required=true)
     */
    protected $expiryYear;

    /**
     * @var string|null
     * @BC\Field(name="verification_value")
     */
    protected $verificationValue;

    /**
     * @var int|null
     * @BC\Field(name="issue_month")
     */
    protected $issueMonth;

    /**
     * @var int|null
     * @BC\Field(name="issue_year")
     */
    protected $issueYear;

    /**
     * @var string|null
     * @BC\Field(name="issue_number")
     */
    protected $issueNumber;

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return \Bigcommerce\ORM\Entities\Card
     */
    public function setType(?string $type): Card
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCardholderName(): ?string
    {
        return $this->cardholderName;
    }

    /**
     * @param string|null $cardholderName
     * @return \Bigcommerce\ORM\Entities\Card
     */
    public function setCardholderName(?string $cardholderName): Card
    {
        $this->cardholderName = $cardholderName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * @param string|null $number
     * @return \Bigcommerce\ORM\Entities\Card
     */
    public function setNumber(?string $number): Card
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getExpiryMonth(): ?int
    {
        return $this->expiryMonth;
    }

    /**
     * @param int|null $expiryMonth
     * @return \Bigcommerce\ORM\Entities\Card
     */
    public function setExpiryMonth(?int $expiryMonth): Card
    {
        $this->expiryMonth = $expiryMonth;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getExpiryYear(): ?int
    {
        return $this->expiryYear;
    }

    /**
     * @param int|null $expiryYear
     * @return \Bigcommerce\ORM\Entities\Card
     */
    public function setExpiryYear(?int $expiryYear): Card
    {
        $this->expiryYear = $expiryYear;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getVerificationValue(): ?string
    {
        return $this->verificationValue;
    }

    /**
     * @param string|null $verificationValue
     * @return \Bigcommerce\ORM\Entities\Card
     */
    public function setVerificationValue(?string $verificationValue): Card
    {
        $this->verificationValue = $verificationValue;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getIssueMonth(): ?int
    {
        return $this->issueMonth;
    }

    /**
     * @param int|null $issueMonth
     * @return \Bigcommerce\ORM\Entities\Card
     */
    public function setIssueMonth(?int $issueMonth): Card
    {
        $this->issueMonth = $issueMonth;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getIssueYear(): ?int
    {
        return $this->issueYear;
    }

    /**
     * @param int|null $issueYear
     * @return \Bigcommerce\ORM\Entities\Card
     */
    public function setIssueYear(?int $issueYear): Card
    {
        $this->issueYear = $issueYear;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIssueNumber(): ?string
    {
        return $this->issueNumber;
    }

    /**
     * @param string|null $issueNumber
     * @return \Bigcommerce\ORM\Entities\Card
     */
    public function setIssueNumber(?string $issueNumber): Card
    {
        $this->issueNumber = $issueNumber;

        return $this;
    }
}