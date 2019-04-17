<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\ProfileImagesTable|\Cake\ORM\Association\BelongsTo $ProfileImages
 * @property \App\Model\Table\CollectionsTable|\Cake\ORM\Association\HasMany $Collections
 * @property \App\Model\Table\CommentsTable|\Cake\ORM\Association\HasMany $Comments
 * @property \App\Model\Table\ResourcesTable|\Cake\ORM\Association\HasMany $Resources
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ProfileImages', [
            'foreignKey' => 'profile_image_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Collections', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Comments', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Resources', [
            'foreignKey' => 'user_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('username')
            ->minLength('username', 3)
            ->maxLength('username', 64)
            ->requirePresence('username', 'create')
            ->allowEmptyString('username', false)
            ->add(
                'username',
                'unique',
                [
                    'rule' => 'validateUnique',
                    'provider' => 'table'
                ]
            );

        $validator
            ->scalar('password')
            ->minLength('password', 6)
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->allowEmptyString('password', false);

        $validator
            ->scalar('passconf')
            ->maxLength('passconf', 255)
            ->requirePresence('passconf', 'create')
            ->allowEmptyString('passconf', false)
            ->add('passconf', [
                'compare' => [
                    'rule' => ['compareWith', 'password']
                ]
            ]);

        $validator
            ->scalar('biography')
            ->maxLength('biography', 255)
            ->allowEmptyString('biography');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->existsIn(['profile_image_id'], 'ProfileImages'));

        return $rules;
    }
}
