<?php

	namespace Crm;

	use Crm\Models\BaseModel;

	class BusyInterval extends BaseModel {
		const NAME = 'Загруженность интервала';

		protected $fillable = [
			'first',
			'second',
			'third',
			'city_id',
			'order_interval_id'
		];

		public function city() {
			return $this->belongsTo(City::class)->withTrashed();
		}

		public function orderInterval() {
			return $this->belongsTo(OrderInterval::class);
		}
	}
