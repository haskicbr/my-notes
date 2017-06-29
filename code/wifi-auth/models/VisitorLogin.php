<?php

/**
 * This is the model class for table "visitor_login".
 *
 * The followings are the available columns in table 'visitor_login':
 * @property integer $id
 * @property string $visitor_login_time
 * @property string $visitor_login_mac
 */
class VisitorLogin extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'visitor_login';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('visitor_login_time', 'required'),
			array('visitor_login_time', 'length', 'max'=>20),
			array('visitor_login_mac', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, visitor_login_time, visitor_login_mac', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'visitor_login_time' => 'Время',
			'visitor_login_mac'  => 'Мак адрес',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('visitor_login_time',$this->visitor_login_time,true);
		$criteria->compare('visitor_login_mac',$this->visitor_login_mac,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VisitorLogin the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    public static function getLastAuth($user_mac){

        if(!empty($user_mac)){

            $max_login_time = time() -  360;
            $sql            = "SELECT * FROM visitor_login lt WHERE lt.visitor_login_time > $max_login_time AND lt.visitor_login_mac = '$user_mac' ";
            $connection   = Yii::app()->db;
            $user_login = $connection->createCommand($sql);
            $user_login = $user_login->queryRow();


            if(!empty($user_login)){
                return true;
            }
        }

        return false;
    }

    public static function createAuth($user_mac){

        $model = new VisitorLogin();

        $model->visitor_login_mac  = $user_mac;
        $model->visitor_login_time = time();

        $model->save();
    }


}
