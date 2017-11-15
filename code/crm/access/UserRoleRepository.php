<?php

	namespace Crm\Repositories;

	use Crm\UserRole;
	use Illuminate\Support\Collection;

	class UserRoleRepository extends AbstractRepository {
		protected function getModelClass() {
			return UserRole::class;
		}

		/**
		 * @return Collection
		 */
		public function getListForGenerate() {
			return $this
				->startConditions()
				->get()
				->keyBy('code');
		}

		/**
		 * @return UserRole|null
		 */
		public function getBaseRole() {
			return $this
				->startConditions()
				->where('code', '=', UserRole::CODE_BASE)
				->first();
		}
	}
