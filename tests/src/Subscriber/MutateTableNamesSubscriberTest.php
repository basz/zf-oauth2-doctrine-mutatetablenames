<?php

namespace ZF\OAuth2\Doctrine\MutateTableNamesTest;

use Doctrine\ORM\Mapping\ClassMetadataInfo;
use ZF\OAuth2\Doctrine\MutateTableNames\EventSubscriber\MutateTableNamesSubscriber;

/**
 * @covers  \ZF\OAuth2\Doctrine\MutateTableNames\EventSubscriber\MutateTableNamesSubscriber
 */
class MutateTableNamesSubscriberTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MutateTableNamesSubscriber
     */
    private $subscriber;

    public function setUp()
    {
        $this->config     = include __DIR__ . '/../../../config/oauth2.doctrine-orm.mutatetablenames.global.php.dist';
        $this->config     = $this->config['zf-oauth2-doctrine']['mutatetablenames'];
        $this->subscriber = new MutateTableNamesSubscriber($this->config);
    }

    public function testSubscribesToCorrectEvents()
    {
        $this->assertSame([\Doctrine\ORM\Events::loadClassMetadata], $this->subscriber->getSubscribedEvents());
    }

    /**
     * @dataProvider dpMetadataListener
     */
    public function testMetadataListener($entityName, $configKey)
    {
        $metadata = $this->getMockBuilder(ClassMetadataInfo::class)->disableOriginalConstructor()->getMock();
        $event    = $this->getMockBuilder(\Doctrine\ORM\Event\LoadClassMetadataEventArgs::class)->disableOriginalConstructor()->getMock();

        $event->expects($this->once())->method('getClassMetadata')->willReturn($metadata);
        $metadata->expects($this->once())->method('getName')->willReturn($entityName);

        // primary table names
        if (isset($this->config[$configKey]['primary_table'])) {
            $metadata->expects($this->once())->method('setPrimaryTable')->with($this->config[$configKey]['primary_table']);
        }

        // associated table names
        if (isset($this->config[$configKey]['associations'])) {
            foreach ($this->config[$configKey]['associations'] as $fieldName => $association) {
                $metadata->expects($this->exactly(count($this->config[$configKey]['associations'])))->method('setAssociationOverride');
                //->with($fieldName, $association)->will($this->returnValue($i));
            }
        }

        $this->subscriber->loadClassMetadata($event);
    }

    public function dpMetadataListener()
    {
        return [
            [
                \ZF\OAuth2\Doctrine\Entity\AccessToken::class,
                'access_token_entity',
            ],
            [
                \ZF\OAuth2\Doctrine\Entity\AuthorizationCode::class,
                'authorization_code_entity',
            ],
            [
                \ZF\OAuth2\Doctrine\Entity\Client::class,
                'client_entity',
            ],
            [
                \ZF\OAuth2\Doctrine\Entity\Jti::class,
                'jti_entity',
            ],
            [
                \ZF\OAuth2\Doctrine\Entity\Jwt::class,
                'jwt_entity',
            ],
            [
                \ZF\OAuth2\Doctrine\Entity\PublicKey::class,
                'public_key_entity',
            ],
            [
                \ZF\OAuth2\Doctrine\Entity\RefreshToken::class,
                'refresh_token_entity',
            ],
            [
                \ZF\OAuth2\Doctrine\Entity\Scope::class,
                'scope_entity',
            ],
        ];
    }
}
