<?php

class Servers extends MainServers
{

    /**
     * check server host
     * @return bool
     */
    public function check()
    {
        $settings = json_decode($this->settings);
        $host = $settings->host;

        exec("ping -c 4 " . $host, $output, $result);

        if ($result == 0) {
            return true;
        }

        return false;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 *
	 * @param string $className active record class name.
	 *
	 * @return MainServers the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
}