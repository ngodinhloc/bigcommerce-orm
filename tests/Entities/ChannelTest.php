<?php
declare(strict_types=1);

namespace Tests\Entities;

use Bigcommerce\ORM\Entities\Channel;
use Tests\BaseTestCase;

class ChannelTest extends BaseTestCase
{
    /** @var \Bigcommerce\ORM\Entities\Channel */
    protected $channel;

    public function testSettersAndGetters()
    {
        $this->channel = new Channel();
        $this->channel
            ->setName('name')
            ->setId(1)
            ->setDateCreated('2020-09-16')
            ->setDateModified('2020-09-17')
            ->setType('web')
            ->setExternalId('012')
            ->setIsEnabled(true)
            ->setPlatform('BC');

        $this->assertEquals('name', $this->channel->getName());
        $this->assertEquals(1, $this->channel->getId());
        $this->assertEquals('2020-09-16', $this->channel->getDateCreated());
        $this->assertEquals('2020-09-17', $this->channel->getDateModified());
        $this->assertEquals('web', $this->channel->getType());
        $this->assertEquals('012', $this->channel->getExternalId());
        $this->assertEquals(true, $this->channel->isEnabled());
        $this->assertEquals('BC', $this->channel->getPlatform());
    }
}