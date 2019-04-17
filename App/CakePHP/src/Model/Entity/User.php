<?php
namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property int $profile_image_id
 * @property string|null $biography
 * @property \Cake\I18n\FrozenTime|null $created
 *
 * @property \App\Model\Entity\ProfileImage $profile_image
 * @property \App\Model\Entity\Collection[] $collections
 * @property \App\Model\Entity\Comment[] $comments
 * @property \App\Model\Entity\Resource[] $resources
 */
class User extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'username' => true,
        'password' => true,
        'profile_image_id' => true,
        'biography' => true,
        'created' => true,
        'profile_image' => true,
        'collections' => true,
        'comments' => true,
        'resources' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];

    protected function _setPassword($value)
    {
        if (strlen($value)) {
            $hasher = new DefaultPasswordHasher();

            return $hasher->hash($value);
        }
    }
}
