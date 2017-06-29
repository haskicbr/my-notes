<?php

/**
 * This is the model class for table "message".
 *
 * The followings are the available columns in table 'message':
 * @property integer $message_id
 * @property integer $message_recipient_id
 * @property integer $message_sender_id
 * @property string $message_text
 * @property string $message_title
 * @property integer $message_status
 * @property integer $message_type
 * @property integer $message_date
 *
 * The followings are the available model relations:
 * @property Users $messageSender
 */
class Message extends CActiveRecord
{

    const STATUS_VIEW     = 1;
    const STATUS_NOT_VIEW = 0;

    const TYPE_SYSTEM     = 2;
    const TYPE_INFO       = 1;
    const TYPE_DELETE     = 3;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'message';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('message_recipient_id, message_sender_id, message_text, message_title, message_status, message_type', 'required'),
			array('message_recipient_id, message_date, message_sender_id, message_status, message_type', 'numerical', 'integerOnly'=>true),
			array('message_text', 'length',  'max'=>500),
			array('message_title', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('message_id, message_recipient_id, message_sender_id, message_text, message_title, message_status, message_type', 'safe', 'on'=>'search'),
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
			'messageSender' => array(self::BELONGS_TO, 'Users', 'message_sender_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'message_id' => 'Message',
			'message_recipient_id' => 'Message Recipient',
			'message_sender_id' => 'Message Sender',
			'message_text' => 'Message Text',
			'message_title' => 'Message Title',
			'message_status' => 'Message Status',
			'message_type' => 'Message Type',
            'message_date' => 'Дата'
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

		$criteria->compare('message_id',$this->message_id);
		$criteria->compare('message_recipient_id',$this->message_recipient_id);
		$criteria->compare('message_sender_id',$this->message_sender_id);
		$criteria->compare('message_text',$this->message_text,true);
		$criteria->compare('message_title',$this->message_title,true);
		$criteria->compare('message_status',$this->message_status);
		$criteria->compare('message_type',$this->message_type);
        $criteria->compare('message_date',$this->message_date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Message the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    public function getDialog($recipient_id, $user_id){

       $dialog =  $this->with('messageSender')->findAllByAttributes(
           array(
               'message_sender_id'    => array($recipient_id, $user_id),
               'message_recipient_id' => array($recipient_id, $user_id)
           )
       );

       return $dialog;
    }


    public function createMessage($sender_id,$recipient_id,$text){

        $this->message_title        = "NO_TITLE";
        $this->message_status       = $this::STATUS_NOT_VIEW;
        $this->message_recipient_id = $recipient_id;
        $this->message_sender_id    = $sender_id;
        $this->message_text         = $text;
        $this->message_type         = $this::TYPE_INFO;
        $this->message_date         = time();

        if($this->save()){

            return true;
        }

        return false;
    }
}
