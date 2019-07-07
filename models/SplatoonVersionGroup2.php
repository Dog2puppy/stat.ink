<?php
/**
 * @copyright Copyright (C) 2015-2017 AIZAWA Hina
 * @license https://github.com/fetus-hina/stat.ink/blob/master/LICENSE MIT
 * @author AIZAWA Hina <hina@fetus.jp>
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "splatoon_version_group2".
 *
 * @property integer $id
 * @property string $tag
 * @property string $name
 *
 * @property SplatoonVersion2[] $versions
 */
class SplatoonVersionGroup2 extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'splatoon_version_group2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag'], 'string', 'max' => 16],
            [['name'], 'string', 'max' => 32],
            [['name'], 'unique'],
            [['tag'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag' => 'Tag',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVersions()
    {
        return $this->hasMany(SplatoonVersion2::class, ['group_id' => 'id']);
    }

    public function getFirstVersion(): ?SplatoonVersion2
    {
        return (count($this->versions) > 0) ? $this->versions[0] : null;
    }

    public function getLastVersion(): ?SplatoonVersion2
    {
        $c = count($this->versions);
        return $c > 0 ? $this->versions[$c - 1] : null;
    }

    public function getNextVersion(): ?SplatoonVersion2
    {
        if (!$lastVersion = $this->getLastVersion()) {
            return null;
        }

        return $lastVersion->nextVersion;
    }
}
