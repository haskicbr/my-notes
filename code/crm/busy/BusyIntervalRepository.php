<?php

	namespace Crm\Repositories;

	use Crm\BusyInterval;
	use Illuminate\Support\Collection;

	class BusyIntervalRepository extends AbstractRepository {
		protected function getModelClass() {
			return BusyInterval::class;
		}

		/**
		 * @param int $cityId
		 * @param int $intervalId
		 * @return Collection
		 */
		public function getBusyIntervalsForCityAndInterval($cityId, $intervalId) {
			return $this
				->startConditions()
				->whereCitiesRegion($cityId)
				->when($intervalId, function ($builder) use ($intervalId) {
					return $builder->where('order_interval_id', '=', $intervalId);
				})
				->get();
		}
	}
