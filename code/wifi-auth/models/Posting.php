<?php

/**
 * This is the model class for table "posting".
 *
 * The followings are the available columns in table 'posting':
 * @property integer $posting_id
 * @property string $posting_title
 * @property integer $posting_type
 * @property string $posting_description
 * @property string $posting_image_url
 * @property string $posting_repost_id
 * @property integer $posting_landing_id
 * @property string $posting_share_url
 * @property integer $posting_period_type
 * @property string $posting_period_time_begin
 * @property string $posting_period_time_end
 * @property string $posting_period_date_begin
 * @property string $posting_period_date_end
 * @property integer $posting_enabled
 * @property string $posting_days_include
 */

class Posting extends CActiveRecord
{

    public $posting_image;  ### КАРТИНКА ДЛЯ ПОСТИНГА ###

    const TIME_ONCE   = 1; ### ПОСТ РАЗМЕЩАЕТСЯ ТОЛЬКО С ПО КАКОЕ ТО ВРЕМЯ ЗАТЕМ СТАТУС МЕНЯЕТСЯ НА 0 ###
    const TIME_ALWAYS = 2; ### ПОСТ РАЗМЕЩАЕТСЯ ПОСТОЯННО С ПО КАКОЕ ТО ВРЕМЯ :)                      ###
    const TIME_MAIN   = 3; ### ПОСТ РАЗМЕЩАЕТСЯ ПОСТОЯННО (ОСНОВНОЙ ПОСТ) ###

    ### ДНИ НЕДЕЛИ ###

    const DAY_MONDAY     = 1;
    const DAY_TUESDAY    = 2;
    const DAY_WEDNESDAY  = 3;
    const DAY_THURSDAY   = 4;
    const DAY_FRIDAY     = 5;
    const DAY_SATURDAY   = 6;
    const DAY_SUNDAY     = 7;

    ### СТАТУС ВКЛЮЧЕНИЯ ВЫКЛЮЧЕНИЯ ПОСТИННА ###

    const POSTING_ON     = 1;
    const POSTING_OFF    = 0;

    public function getPostActive(){
        if($this->posting_enabled == $this::POSTING_ON) return "<input class='enabled-posting' data-id='".$this->posting_id."' checked type='checkbox'/>";
            return "<input class='enabled-posting' data-id='".$this->posting_id."' type='checkbox'/>";
    }

    public function getTimeType(){
        if($this->posting_period_type == $this::TIME_ALWAYS){
            return "Постоянно";
        }else{
            return "Единожды";
        }

    }

    ### ВЫВОД ДНЕЙ НЕДЕЛИ ПОСТА ###

    public function getWeekdaysToString(){

        if(!empty($this->posting_days_include)){

            $weekdays = unserialize($this->posting_days_include);
            $days_string = "";

            foreach($weekdays as $day){

                switch($day){

                    case(1): $day = "ПН ";
                        break;
                    case(2): $day = "ВТ ";
                        break;
                    case(3): $day = "СР ";
                        break;
                    case(4): $day = "ЧТ ";
                        break;
                    case(5): $day = "ПТ ";
                        break;
                    case(6): $day = "СБ ";
                        break;
                    case(7): $day = "ВС ";
                        break;
                }

                $days_string .= $day;
            }

            return $days_string;
        }

        return false;
    }

    ### СТРОКИ ДЛЯ ДНЕЙ НЕДЕЛи В ГРАФЕ DATE ДЛЯ СРАВНЕНИЯ ###

    const POSTING_SUNDAY    = 'Sun';
    const POSTING_SATURDAY  = 'Sat';
    const POSTING_FRIDAY    = 'Fri';
    const POSTING_THURSDAY  = 'Thu';
    const POSTING_WEDNESDAY = 'Wed';
    const POSTING_TUESDAY   = 'Tue';
    const POSTING_MONDAY    = 'Mon';

    ### ДЛЯ СРАВНЕНИЯ ДНЕЙ НЕДЕЛИ ###

    public static function getWeekday($day){

        $day = (int) $day;

        switch($day){

            case(1): return self::POSTING_MONDAY;
                break;
            case(2): return self::POSTING_TUESDAY;
                break;
            case(3): return self::POSTING_WEDNESDAY;
                break;
            case(4): return self::POSTING_THURSDAY;
                break;
            case(5): return self::POSTING_FRIDAY;
                break;
            case(6): return self::POSTING_SATURDAY;
                break;
            case(7): return self::POSTING_SUNDAY;
                break;
        }

        return false;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'posting';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('posting_type, posting_landing_id, posting_title, posting_description', 'required'),
            array('posting_type, posting_landing_id, posting_period_type, posting_enabled', 'numerical', 'integerOnly'=>true, 'message' =>'Выберите {attribute}'),
            array('posting_title, posting_repost_id, posting_days_include', 'length', 'max'=>255),
            array('posting_image_url, posting_share_url', 'length', 'max'=>500),
            array('posting_description, posting_period_time_begin, posting_period_time_end, posting_period_date_begin, posting_period_date_end', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('posting_id, posting_title, posting_type, posting_description, posting_image_url, posting_repost_id, posting_landing_id, posting_share_url, posting_period_type, posting_period_time_begin, posting_period_time_end, posting_period_date_begin, posting_period_date_end, posting_enabled, posting_days_include', 'safe', 'on'=>'search'),
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
            'posting_id' => 'Posting',
            'posting_title' => 'Заголовок',
            'posting_type' => 'соц сеть',
            'posting_description' => 'Описание',
            'posting_image_url' => 'Изображение',
            'posting_repost_id' => 'Posting Repost',
            'posting_landing_id' => 'Posting Landing',
            'posting_share_url' => 'Ссылка на ресурс',
            'posting_period_type' => 'Времянной тип',
            'posting_period_time_begin' => 'Время начала',
            'posting_period_time_end' => 'Время окончания',
            'posting_period_date_begin' => 'Дата начала',
            'posting_period_date_end' => 'Дата окончания',
            'posting_enabled' => 'Posting Enabled',
            'posting_days_include' => 'Дни недели',
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

        $criteria->compare('posting_id',$this->posting_id);
        $criteria->compare('posting_title',$this->posting_title,true);
        $criteria->compare('posting_type',$this->posting_type);
        $criteria->compare('posting_description',$this->posting_description,true);
        $criteria->compare('posting_image_url',$this->posting_image_url,true);
        $criteria->compare('posting_repost_id',$this->posting_repost_id,true);
        $criteria->compare('posting_landing_id',$this->posting_landing_id);
        $criteria->compare('posting_share_url',$this->posting_share_url,true);
        $criteria->compare('posting_period_type',$this->posting_period_type);
        $criteria->compare('posting_period_time_begin',$this->posting_period_time_begin,true);
        $criteria->compare('posting_period_time_end',$this->posting_period_time_end,true);
        $criteria->compare('posting_period_date_begin',$this->posting_period_date_begin,true);
        $criteria->compare('posting_period_date_end',$this->posting_period_date_end,true);
        $criteria->compare('posting_enabled',$this->posting_enabled);
        $criteria->compare('posting_days_include',$this->posting_days_include,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Posting the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getNowPost(){

        $posting = $this;

        if($posting->posting_period_type == Posting::TIME_ALWAYS && $posting->posting_enabled == $this::POSTING_ON){

            $days_include = unserialize($posting->posting_days_include);

            if(is_array($days_include)){

                foreach($days_include as $day){

                    if(Posting::getWeekday($day) == date('D')){

                        $hours_begin  = date('H',strtotime($posting->posting_period_time_begin));
                        $minute_begin = date('i',strtotime($posting->posting_period_time_begin));

                        $hours_end    = date('H',strtotime($posting->posting_period_time_end));
                        $minute_end   = date('i',strtotime($posting->posting_period_time_end));

                        $hours_now    = date('H');
                        $minute_now   = date('i');

                        $time_end     = strtotime("$hours_end:$minute_end");
                        $time_begin   = strtotime("$hours_begin:$minute_begin");
                        $time_now     = strtotime("$hours_now:$minute_now");


                        $time_end     = $time_end   - (60*60*2);
                        $time_begin   = $time_begin - (60*60*2);

                        ### СРАВНЕНИЕ ВРЕМЕНИ РАЗМЕЩЕНИЯ ПОСТА ###

                        if($time_begin <= $time_now && $time_now <= $time_end){

                            return true;
                        }
                    }
                }
            }
        }

        if($posting->posting_period_type == Posting::TIME_ONCE   && $posting->posting_enabled == $this::POSTING_ON){

            $date_begin = $posting->posting_period_date_begin;
            $date_end   = $posting->posting_period_date_end;

            $date_begin = strtotime($date_begin);
            $date_end   = strtotime($date_end);

            if($date_begin <= time() && time() <= $date_end){
                 return true;
            }
        }

        return false;
    }


}
