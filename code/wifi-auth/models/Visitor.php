<?php

/**
 * This is the model class for table "visitor".
 *
 * The followings are the available columns in table 'visitor':
 * @property integer $id
 * @property integer $visitor_id
 * @property integer $visitor_page_id
 * @property integer $visitor_login_time
 * @property string $visitor_phone
 * @property string $visitor_name
 * @property string $visitor_last_name
 * @property string $visitor_middle_name
 * @property integer $visitor_type
 * @property integer $visitor_gender
 * @property string $visitor_avatar
 * @property string $visitor_city
 * @property string $visitor_birth_date
 * @property integer $visitor_device
 * @property integer $visitor_os
 */


class Visitor extends CActiveRecord
{

    const VK_TYPE        = 1; ### ТИП ДЛЯ VK.COM                ###
    const FB_TYPE        = 2; ### ТИП ДЛЯ FACEBOOK.COM          ###
    const PHONE_TYPE     = 3; ### ТИП ДЛЯ СМС АВТОРИЗАЦИИ       ###
    const OK_TYPE        = 4; ### ТИП ДЛЯ ОДНОКЛАССНИКОВ ok.ru  ###
    const IG_TYPE        = 5; ### ТИП ДЛЯ ИНСТАГРАММА           ###
    const TW_TYPE        = 6; ### ТИПА ДЛЯ ТВИТТЕРА             ###

    ### ОПЕРАЦИОННЫЕ СИСТЕМЫ ###
    const OS_ANDROID      = 1;
    const OS_MAC          = 2;
    const OS_WINDOWS      = 3;
    const OS_OTHER        = 4;

    ### ТИП УСТРОЙСТВА     ###
    const DEVICE_MOBILE   = 1;
    const DEVICE_TABLET   = 2;
    const DEVICE_COMPUTER = 3;
    const DEVICE_OTHER    = 4;

    ### ПОЛ ПОСЕТИТЕЛЕЙ   ###
    const VISITOR_MALE   = 2;
    const VISITOR_FEMALE = 1;

    ### ДАННЫЕ ДЛЯ КОНТАКТА ###

    const VK_MALE   = 2;
    const VK_FEMALE = 1;

    ### ПОСЕТИТЕЛИ БЕЗ ВОЗРАСТА ###
    public $no_age = 0;

    /**
     * @return string the associated database table name
     */

    public function tableName()
    {
        return 'visitor';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('visitor_id, visitor_page_id, visitor_login_time, visitor_type', 'required'),
            array('visitor_page_id, visitor_login_time, visitor_type, visitor_gender, visitor_device, visitor_os', 'numerical', 'integerOnly'=>true),
            array('visitor_id, visitor_phone, visitor_city', 'length', 'max'=>255),
            array('visitor_name, visitor_last_name, visitor_middle_name, visitor_birth_date', 'length', 'max'=>50),
            array('visitor_avatar', 'length', 'max'=>500),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, visitor_id, visitor_page_id, visitor_login_time, visitor_phone, visitor_name, visitor_last_name, visitor_middle_name, visitor_type, visitor_gender, visitor_avatar, visitor_city, visitor_birth_date', 'safe', 'on'=>'search'),
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
            'visitor_id' => 'Visitor',
            'visitor_page_id' => 'Visitor Page',
            'visitor_login_time' => 'Visitor Login Time',
            'visitor_phone' => 'Visitor Phone',
            'visitor_name' => 'Visitor Name',
            'visitor_last_name' => 'Visitor Last Name',
            'visitor_middle_name' => 'Visitor Middle Name',
            'visitor_type' => 'Visitor Type',
            'visitor_gender' => 'Visitor Gender',
            'visitor_avatar' => 'Visitor Avatar',
            'visitor_city' => 'Visitor City',
            'visitor_birth_date' => 'Visitor Birth Date',
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
        $criteria->compare('visitor_id',$this->visitor_id);
        $criteria->compare('visitor_page_id',$this->visitor_page_id);
        $criteria->compare('visitor_login_time',$this->visitor_login_time);
        $criteria->compare('visitor_phone',$this->visitor_phone,true);
        $criteria->compare('visitor_name',$this->visitor_name,true);
        $criteria->compare('visitor_last_name',$this->visitor_last_name,true);
        $criteria->compare('visitor_middle_name',$this->visitor_middle_name,true);
        $criteria->compare('visitor_type',$this->visitor_type);
        $criteria->compare('visitor_gender',$this->visitor_gender);
        $criteria->compare('visitor_avatar',$this->visitor_avatar,true);
        $criteria->compare('visitor_city',$this->visitor_city,true);
        $criteria->compare('visitor_birth_date',$this->visitor_birth_date,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Visitor the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getType($type = false){

        if(!$type){

            $type = $this->visitor_type;
        }

        switch($type){

            case $this::PHONE_TYPE:
                return '<img width="30px" src="/images/wi-fi/sms.png" alt="">';
            break;

            case $this::VK_TYPE:
                return '<img width="30px" src="/images/wi-fi/vk.jpg">';
            break;

            case $this::FB_TYPE:
                return '<img width="30px" src="/images/wi-fi/fb.png">';
            break;

            case $this::IG_TYPE:
                return '<img width="30px" src="/images/wi-fi/ig.png">';
            break;

            case $this::OK_TYPE:
                return '<img width="30px" src="/images/wi-fi/ok.png">';
            break;

            case $this::TW_TYPE:
                return '<img width="30px" src="/images/wi-fi/tw.png">';
            break;
        }

        return false;
    }

    public function getGender($gender = false){

        if(!$gender){
            $this->visitor_gender = $gender;
        }


        switch($gender){

            case $this::VISITOR_MALE:
                return 'мужской';
            break;

            case $this::VISITOR_FEMALE:
                return 'женский';
            break;

            default: return 'не указан';
        }
    }

    public function getGenderFromVk($vk_gender){

        if($vk_gender == $this::VK_MALE){

            return $this::VISITOR_MALE;
        }else{
            return $this::VISITOR_FEMALE;
        }
    }

    public function getGenderFromFb($fbGender){

        switch($fbGender){

            case 'male':
                return $this::VISITOR_MALE;
            break;

            case 'female':
                return $this::VISITOR_FEMALE;
            break;
        }

        return false;
    }

    public function getGenderFromOk($okGender){

        switch($okGender){

            case 'male':
                return $this::VISITOR_MALE;
            break;

            case 'female':
                return $this::VISITOR_FEMALE;
            break;
        }

        return false;
    }

    public static function getCalendarMonth($month){

        switch($month){

            case "01":
               return 'январь';
            break;

            case "02":
                return 'февраль';
            break;

            case "03":
                return 'март';
            break;

            case "04":
                return 'апрель';
            break;

            case "05":
                return 'май';
            break;

            case "06":
                return 'июнь';
            break;

            case "07":
                return 'июль';
            break;

            case "08":
                return 'август';
            break;

            case "09":
                return 'сентябрь';
            break;

            case "10":
                return 'октябрь';
            break;

            case "11":
                return 'ноябрь';
            break;

            case "12":
                return 'декабрь';
            break;
        }

        return $month;
    }

    public function setVisitorDevice(){

        $detect = new Mobile_Detect;

        if ($detect->isMobile()) {
            $this->visitor_device = $this::DEVICE_MOBILE;

            return true;
        }

        if( $detect->isTablet() ){
            $this->visitor_device = $this::DEVICE_TABLET;

            return true;
        }

        if( !$detect->isMobile() && !$detect->isTablet() ){
            $this->visitor_device = $this::DEVICE_COMPUTER;

            return true;
        }

        return $this::DEVICE_OTHER;
    }

    public function setVisitorOs(){

        $detect = new Mobile_Detect;

        if($detect->isiOS()){
            $this->visitor_os = $this::OS_MAC;
            return true;
        }

        if($detect->isAndroidOS()){
            $this->visitor_os = $this::OS_ANDROID;
            return true;
        }

        if(!$detect->isAndroidOS() && !$detect->isiOS()){
            $this->visitor_os = $this::OS_WINDOWS;
            return true;
        }

        return false;
    }

    public function getVisitorOsIco($type=false){

        if(!$type){
            $type = $this->visitor_os;
        }

        switch($type){

            case($this::OS_ANDROID):
                return '<i class="fa fa-fw fa-android"></i>';
            case($this::OS_MAC):
                return '<i class="fa fa-fw  fa-apple"></i>';
            case($this::OS_WINDOWS):
                return '<i class="fa fa-fw  fa-windows"></i>';
        }

        return false;
    }

    public function getVisitorDeviceIco($type=false){

        if(!$type){
            $type = $this->visitor_device;
        }

        switch($type){

            case($this::DEVICE_MOBILE):
                return '<i class="fa fa-fw fa-mobile"></i>';
            case($this::DEVICE_TABLET):
                return '<i class="fa fa-fw fa-tablet"></i>';
            case($this::DEVICE_COMPUTER):
                return '<i class="fa fa-fw fa-laptop"></i>';
        }

        return false;
    }


    public function getVisitorLink($type = false, $visitor_id = false, $visitor_name = false){

        if(!$type){
            $type = $this->visitor_type;
        }

        if(!$visitor_id){
            $visitor_id = $this->visitor_id;
        }

        if(!$visitor_name){
            $visitor_name = $this->visitor_name;
        }

        switch($type){
            case Visitor::VK_TYPE:
                return 'http://vk.com/id'.$visitor_id;
            case Visitor::FB_TYPE:
                return 'http://fb.com/'.$visitor_id;
            case VISITOR::OK_TYPE:
                return 'http://ok.ru/profile/'.$visitor_id;
            case VISITOR::TW_TYPE:
                return 'https://twitter.com/'.$visitor_id;
            case VISITOR::IG_TYPE:
                return  'https://instagram.com/'.$visitor_name;
        }

        return '#';
    }
    
    public function getAuthReview(){
        $cookie = Yii::app()->request->cookies['auth_review']->value;

        if(!empty($cookie)) {

            return (int) $cookie;
        } else {

            return false;
        }
    }

    public static function setDate($string_time){

        return strtotime(date('Y-m-d').' '.$string_time);
    }
    
    protected function afterSave(){

        Yii::app()->request->cookies['auth_visitor'] = new CHttpCookie('auth_visitor', $this->id, array('path' => '/', 'expire' => time() + 60*60*24));

        parent::afterSave();
    }

    public function getAuthVisitor(){

        $cookie = Yii::app()->request->cookies['auth_visitor']->value;

        return $cookie;
    }
}
