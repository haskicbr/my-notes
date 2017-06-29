<?php

/**
 * This is the model class for table "post".
 *
 * The followings are the available columns in table 'post':
 * @property integer $post_id
 * @property string $post_title
 * @property integer $post_type
 * @property string $post_description
 * @property string $post_image_url
 * @property string $post_repost_id
 * @property string $post_group_id
 * @property integer $post_action_type
 * @property integer $post_landing_id
 * @property string $post_share_url
 *
 * The followings are the available model relations:
 * @property Landing $postLanding
 */
class Post extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'post';
    }

    public $post_image; ### КАРТИНКА ДЛЯ ПОСТА ###

    const VK_TYPE  = 1; ### ТИП ДЛЯ VK.COM                ###
    const FB_TYPE  = 2; ### ТИП ДЛЯ FACEBOOK.COM          ###
    const OK_TYPE  = 4; ### ТИП ДЛЯ ОДНОКЛАССНИКОВ ok.ru  ###
    const IG_TYPE  = 5; ### ТИП ДЛЯ ИНСТАГРАММА           ###
    const TW_TYPE  = 6; ### ТИП ДЛЯ ТВИТТЕРА              ###
    const SMS_TYPE = 7; ### ТИП СМС АВТОРИЗАЦИИ           ###
    const SIP_TYPE = 8; ### SIP АВТОРИЗАЦИЯ               ###


    public function getPostTypes(){

        return array(

            self::VK_TYPE   => 'Вконтакте'     ,
            self::FB_TYPE   => 'Facebook'      ,
            self::OK_TYPE   => 'Одноклассники' ,
            self::TW_TYPE   => 'Twitter'       ,
            self::IG_TYPE   => 'Instagram',
            self::SMS_TYPE  => 'СМС авторизация'
        );
    }


    public function getPostType($type=false){

        if(!$type){

            $type = $this->post_type;
        }

        switch($type){

            case self::VK_TYPE:
                return '<img width="30px" src="/images/wi-fi/vk.jpg">';
                break;

            case self::FB_TYPE:
                return '<img width="30px" src="/images/wi-fi/fb.png">';
                break;

            case self::IG_TYPE:
                return '<img width="30px" src="/images/wi-fi/ig.png">';
                break;

            case self::OK_TYPE:
                return '<img width="30px" src="/images/wi-fi/ok.png">';
                break;

            case self::TW_TYPE:
                return '<img width="30px" src="/images/wi-fi/tw.png">';
                break;

            case self::SMS_TYPE:
                return '<img width="30px" src="/images/wi-fi/sms.png">';
                break;

            default: return false;
        }
    }

    public function getPostingAttributes($posting){

        $this->post_image_url   = $posting->posting_image_url;
        $this->post_description = $posting->posting_description;
        $this->post_share_url   = $posting->posting_share_url;
        $this->post_title       = $posting->posting_title;
    }

    /**
     * @return array validation rules for model attributes.
     */

    public function rules(){

        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('post_image', 'file', 'types'=>'jpg,jpeg,png','maxSize'=>5*1024*1024, 'allowEmpty' => true),
            array('post_type, post_landing_id, post_title, post_description', 'required'),
            array('post_type, post_action_type, post_landing_id', 'numerical', 'integerOnly'=>true),
            array('post_title, post_repost_id, post_group_id', 'length', 'max'=>255),
            array('post_image_url, post_share_url', 'length', 'max'=>500),
            array('post_description', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('post_id, post_title, post_type, post_share_url, post_description, post_image_url, post_repost_id, post_group_id, post_action_type, post_landing_id', 'safe', 'on'=>'search'),
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
            'postLanding' => array(self::BELONGS_TO, 'Landing', 'post_landing_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'post_id'          => 'id',
            'post_title'       => 'Заголовок',
            'post_type'        => 'Тип',
            'post_description' => 'Описание',
            'post_image_url'   => 'Изображение',
            'post_landing_id'  => 'Страница авторизации',
            'post_share_url'   => 'URL рекламной страницы',
            'post_group_id'    => 'Post Group',
            'post_action_type' => 'Post Action Type',
            'post_repost_id'   => 'Post Repost',
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

        $criteria->compare('post_id',$this->post_id);
        $criteria->compare('post_title',$this->post_title,true);
        $criteria->compare('post_type',$this->post_type);
        $criteria->compare('post_description',$this->post_description,true);
        $criteria->compare('post_image_url',$this->post_image_url,true);
        $criteria->compare('post_repost_id',$this->post_repost_id,true);
        $criteria->compare('post_group_id',$this->post_group_id,true);
        $criteria->compare('post_action_type',$this->post_action_type);
        $criteria->compare('post_landing_id',$this->post_landing_id);
        $criteria->compare('post_share_url',$this->post_share_url,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Post the static model class
     */
    public static function model($className=__CLASS__){

        return parent::model($className);
    }


    public function getAuthButton($router_id){
        switch($this->post_type){

            case($this::VK_TYPE):

                if($router_id){
                    $link='/post/vk/id/'.$router_id;
                }else{
                    $link = '#';
                }

                return '<div data-href="'.$link.'" class="auth-vk auth-link"></div>';

            case($this::FB_TYPE):

                if($router_id){
                    $link='/post/fb/id/'.$router_id;
                }else{
                    $link = '#';
                }

                return '<div data-href="'.$link.'" class="auth-fb auth-link"></div>';

            case($this::OK_TYPE):

                if($router_id){
                    $link='/auth/ok/id/'.$router_id;
                }else{
                    $link = '#';
                }

                return '<div data-href="'.$link.'" class="auth-ok auth-link"></div>';

            case($this::IG_TYPE):

                if($router_id){
                    $link='/auth/ig/id/'.$router_id;
                }else{
                    $link = '#';
                }

                return '<div data-href="'.$link.'" class="auth-ig auth-link"></div>';

            case($this::TW_TYPE):

                if($router_id){
                    $link='/auth/tw/id/'.$router_id;
                }else{
                    $link = '#';
                }

                return '<div data-href="'.$link.'" class="auth-tw auth-link"></div>';


            case($this::SMS_TYPE):
                
                return '<div class="auth-sms"></div>';

        }

        return false;
    }
}
