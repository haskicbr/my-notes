<?php

	namespace Crm\Http\Requests;


	class CreateBusyIntervalRequest extends Request {
		protected $messages = [
			'required' => 'поле обязательно к заполнению',
		];

		public function rules() {
			return [
				'city_id'           => 'required',
				'order_interval_id' => 'required',
				'first'             => 'required',
				'second'            => 'required',
				'third'             => 'required',
			];
		}
	}
