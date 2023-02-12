<template>
	<div class="flex flex-col max-w-3xl mx-auto p-6 space-y-4 sm:p-10 bg-gray-800 text-gray-100">
		<h2 class="text-xl font-semibold text-center">Votre Panier</h2>
		<ul class="flex flex-col divide-y divide-gray-700">
			<li v-for="item in items" :key="items.id" class="flex flex-col py-6 sm:flex-row sm:justify-between">
				<div class="flex w-full space-x-2 sm:space-x-4">
					<img class="flex-shrink-0 object-cover w-20 h-20 dark:border-transparent rounded outline-none sm:w-32 sm:h-32 dark:bg-gray-500" src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/66/Queen%27s_Theatre_by_Day_Cropped.png/270px-Queen%27s_Theatre_by_Day_Cropped.png">
					<div class="flex flex-col justify-between w-full pb-4">
						<div class="flex justify-between w-full pb-2 space-x-2">
							<div class="space-y-1">
								<h3 class="text-lg font-semibold leading-snug sm:pr-8">{{ item.name }}</h3>
								<p class="text-sm dark:text-gray-400">Pièce de Théatre</p>
							</div>
							<div class="flex items-center space-x-2">
								<button @click="decrementQuantity(item)"  class="bg-gray-700 hover:bg-gray-600 text-gray-100 font-bold py-2 px-4 rounded" >-</button>
									<span class="text-gray-100 font-bold py-2 px-4 rounded">
										{{ item.quantity }}
									</span>
								<button @click="incrementQuantity(item)"  class=" bg-gray-700 hover:bg-gray-600 text-gray-100 font-bold py-2 px-4 rounded">+</button>
							</div>
							<div class="text-right">
								<p class="text-lg font-semibold">25€</p>
							</div>
						</div>
						<div class="flex text-sm divide-x">
							<button  @click="removeItem(item)" type="button" class="flex items-center px-2 py-1 pl-0 space-x-1">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-4 h-4 fill-current">
									<path d="M96,472a23.82,23.82,0,0,0,23.579,24H392.421A23.82,23.82,0,0,0,416,472V152H96Zm32-288H384V464H128Z"></path>
									<rect width="32" height="200" x="168" y="216"></rect>
									<rect width="32" height="200" x="240" y="216"></rect>
									<rect width="32" height="200" x="312" y="216"></rect>
									<path d="M328,88V40c0-13.458-9.488-24-21.6-24H205.6C193.488,16,184,26.542,184,40V88H64v32H448V88ZM216,48h80V88H216Z"></path>
								</svg>
								<span>Supprimer</span>
							</button>
						</div>
					</div>
				</div>
			</li>
		</ul>
		<div class="space-y-1 text-right">
			<p>Total (TTC):
				<span class="font-semibold">25€</span>
			</p>
		</div>
		<div class="flex justify-end space-x-4">
			<button type="button" class="px-6 py-2 border rounded-md dark:border-violet-400">
				<span class="sr-only sm:not-sr-only">Retour</span>
			</button>
			<button type="button" class="px-6 py-2 border rounded-md dark:bg-violet-400 dark:text-gray-900 dark:border-violet-400">
				<span class="sr-only sm:not-sr-only">Passer à l'étape suivante</span>
			</button>
		</div>
	</div>
</template>

<script setup>
import { reactive, ref } from 'vue';

const items = reactive(JSON.parse(localStorage.getItem('cart')) || []);

const incrementQuantity = (item) => {
	item.quantity++;
	saveCartToLocalStorage();
};

const decrementQuantity = (item) => {
	item.quantity--;
	saveCartToLocalStorage();
};

const removeItem = (item) => {
	items.splice(items.indexOf(item), 1);
	saveCartToLocalStorage();
};

const saveCartToLocalStorage = () => {
      localStorage.setItem('cart', JSON.stringify(this.cart));
    }


</script>