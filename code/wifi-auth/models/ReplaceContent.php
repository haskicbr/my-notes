<?php

/**
 * This is the model class for table "replace_content".
 *
 * The followings are the available columns in table 'replace_content':
 * @property integer $replace_content_id
 * @property string $replace_content_name
 * @property string $replace_content_description
 * @property string $replace_content_element
 * @property string $replace_content_url
 */
class ReplaceContent extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'replace_content';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('replace_content_description, replace_content_element, replace_content_url', 'required'),
			array('replace_content_name', 'length', 'max'=>100),
			array('replace_content_description', 'length', 'max'=>500),
			array('replace_content_url', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('replace_content_id, replace_content_name, replace_content_description, replace_content_element, replace_content_url', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'replace_content_id'          => 'Replace Content',
			'replace_content_name'        => 'Replace Content Name',
			'replace_content_description' => 'Replace Content Description',
			'replace_content_element'     => 'Replace Content Element',
			'replace_content_url'         => 'Replace Content Url',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('replace_content_id',$this->replace_content_id);
		$criteria->compare('replace_content_name',$this->replace_content_name,true);
		$criteria->compare('replace_content_description',$this->replace_content_description,true);
		$criteria->compare('replace_content_element',$this->replace_content_element,true);
		$criteria->compare('replace_content_url',$this->replace_content_url,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ReplaceContent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function setReplace(){
        Yii::app()->request->cookies['replace_url'] = new CHttpCookie('replace_url', $this->replace_content_url , array( 'expire' => time() + 60 * 60 * 24, 'path' => '/' ));
    }

    public function getReplace(){
        $value = Yii::app()->request->cookies['replace_url'];

        return $value;
    }
}
