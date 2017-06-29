<?php

/**
 * This is the model class for table "notice".
 *
 * The followings are the available columns in table 'notice':
 * @property integer $notice_id
 * @property string $notice_name
 * @property string $notice_title
 * @property string $notice_description
 * @property integer $notice_recipient_id
 * @property string $notice_type
 * @property integer $notice_date
 * @property integer $notice_status
 *
 * The followings are the available model relations:
 * @property User $noticeRecipient
 */
class Notice extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */

    const STATUS_ACTIVE   = 1;
    const STATUS_DEACTIVE = 0;


    const TYPE_ERROR   = 4;
    const TYPE_WARNING = 3;
    const TYPE_SUCCESS = 2;
    const TYPE_PRIMARY = 1;

	public function tableName()
	{
		return 'notice';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('notice_recipient_id, notice_type, notice_date, notice_status', 'required'),
			array('notice_recipient_id, notice_date, notice_status', 'numerical', 'integerOnly'=>true),
			array('notice_name', 'length', 'max'=>50),
			array('notice_title, notice_type', 'length', 'max'=>255),
			array('notice_description', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('notice_id, notice_name, notice_title, notice_description, notice_recipient_id, notice_type, notice_date, notice_status', 'safe', 'on'=>'search'),
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
			'noticeRecipient' => array(self::BELONGS_TO, 'Users', 'notice_recipient_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'notice_id'           => 'Notice',
			'notice_name'         => 'Название',
			'notice_title'        => 'Заголовок',
			'notice_description'  => 'Текст',
			'notice_recipient_id' => 'Получатель',
			'notice_type'         => 'Тип',
			'notice_date'         => 'Дата',
			'notice_status'       => 'Статус',

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

		$criteria->compare('notice_id',$this->notice_id);
		$criteria->compare('notice_name',$this->notice_name,true);
		$criteria->compare('notice_title',$this->notice_title,true);
		$criteria->compare('notice_description',$this->notice_description,true);
		$criteria->compare('notice_recipient_id',$this->notice_recipient_id);
		$criteria->compare('notice_type',$this->notice_type,true);
		$criteria->compare('notice_date',$this->notice_date);
		$criteria->compare('notice_status',$this->notice_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Notice the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    public static function getNoticeType($type){

        switch($type){

            case self::TYPE_ERROR:   return "error";
            case self::TYPE_SUCCESS: return "success";
            case self::TYPE_PRIMARY: return "info";
            case self::TYPE_WARNING: return "warning";

            default : return "info";
        }
    }

    public static function getUserNotice($user_id){
        $model       = new Notice;
        $user_notice = $model->findAllByAttributes(array('notice_recipient_id' => $user_id, 'notice_status' => self::STATUS_ACTIVE));

        if(!empty($user_notice)){

            $json = array();
            foreach($user_notice as $notice){
                /** @var $notice Notice  */

                $notice_array = array(

                    'title' => $notice->notice_title,
                    'type'  => self::getNoticeType($notice->notice_type),
                    'text'  => $notice->notice_description,
                    'id'    => $notice->notice_id
                );

                $json[] = $notice_array;
            }

            return CJSON::encode($json);
        }

        return false;
    }

    public static function create($user_id,$title,$description,$type,$name) {

        $model = new Notice;
        $model->notice_type         = $type;
        $model->notice_description  = $description;
        $model->notice_name         = $name;
        $model->notice_title        = $title;
        $model->notice_recipient_id = $user_id;
        $model->notice_date         = time();
        $model->notice_status       = self::STATUS_ACTIVE;

        if($model->save()){
            return true;
        }

        return false;
    }
}
