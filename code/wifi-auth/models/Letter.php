<?php

/**
 * This is the model class for table "letter".
 *
 * The followings are the available columns in table 'letter':
 * @property integer $letter_id
 * @property string $letter_name
 * @property string $letter_description
 * @property string $letter_content
 * @property string $letter_subject
 */
class Letter extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'letter';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('letter_name', 'length', 'max'=>50),
			array('letter_description, letter_subject', 'length', 'max'=>255),
			array('letter_content', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('letter_id, letter_name, letter_description, letter_content, letter_subject', 'safe', 'on'=>'search'),
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

			'letter_id'          => 'id',
			'letter_name'        => 'название',
			'letter_description' => 'описание',
			'letter_content'     => 'контент',
			'letter_subject'     => 'тема',
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

		$criteria->compare('letter_id',$this->letter_id);
		$criteria->compare('letter_name',$this->letter_name,true);
		$criteria->compare('letter_description',$this->letter_description,true);
		$criteria->compare('letter_content',$this->letter_content,true);
		$criteria->compare('letter_subject',$this->letter_subject,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Letter the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function send($recipient){


        $mail_status = self::sendMessage($recipient, $this->letter_subject, $this->letter_content);

        if($mail_status){

            $sent = new LetterSent;
            $sent->letter_sent_name      = $this->letter_name;
            $sent->letter_sent_time      = time();
            $sent->letter_sent_recipient = $recipient;

            if($sent->validate()){
                $sent->save(false);
            }

            return true;

        }else{

            $errors[] = 'Sorry, your message could not be sent, ';

            return false;
        }
    }


    public static function sendMessage($recipient,$subject,$message,$attachment = false){

        $__smtp = array(
            "host"     => "smtp.yandex.ru",     //smtp сервер
            "debug"    => 0,                  //отображение информации дебаггера (0 - нет вообще)
            "auth"     => true,               //сервер требует авторизации
            "port"     => 25,                 //порт (по-умолчанию - 25)
            "username" => "noreply@wifi4biz.com",  //имя пользователя на сервере
            "password" => "haskicbr",     //пароль
            "addreply" => "noreply@wifi4biz.com",  //ваш е-mail
            "replyto"  => "noreply@wifi4biz.com"   //e-mail ответа
        );

        $mail = new PHPMailer(true);

        $mail->IsSMTP();
        $mail->CharSet = "UTF-8";

        try {

            $mail->Host       = $__smtp['host'];
            $mail->SMTPDebug  = $__smtp['debug'];
            $mail->SMTPAuth   = $__smtp['auth'];
            $mail->Port       = $__smtp['port'];
            $mail->Username   = $__smtp['username'];
            $mail->Password   = $__smtp['password'];

            $mail->AddReplyTo($__smtp['addreply'], $__smtp['username']);

            if(is_array($recipient)){

                foreach($recipient as $item){
                    $mail->AddAddress($item);
                }
            }else{
                $mail->AddAddress($recipient);
            }

            $mail->SetFrom($__smtp['addreply'], $__smtp['username']); //от кого (желательно указывать свой реальный e-mail на используемом SMTP сервере
            $mail->AddReplyTo($__smtp['addreply'], $__smtp['username']);
            # $mail->Subject = htmlspecialchars('SUBJECT');
            # $mail->MsgHTML("CONTENT");

            $mail->IsHTML(true);

            $mail->Subject = $subject;
            $mail->Body    = $message;

            if($attachment)  $mail->AddAttachment($attachment);
            $mail->Send();
            # echo "Message sent Ok!</p>\n";


            return true;

        } catch (phpmailerException $e) {
            //echo $e->errorMessage();

            return false;
        } catch (Exception $e) {
            //echo $e->getMessage();
            return false;
        }
    }
}
