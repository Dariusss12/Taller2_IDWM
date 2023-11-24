<template>
    <TransitionRoot appear :show="isOpen" as="template">
      <Dialog as="div" class="relative z-[50]" @close="closeModal">
        <TransitionChild
          as="template"
          enter="duration-300 ease-out"
          enter-from="opacity-0"
          enter-to="opacity-100"
          leave="duration-200 ease-in"
          leave-from="opacity-100"
          leave-to="opacity-0"
        >
        <div class="fixed inset-0 bg-black bg-opacity-80" />
        </TransitionChild>
  
        <div class="fixed inset-0 overflow-y-auto">
          <div class="flex min-h-full items-center justify-center p-4">
            <TransitionChild
              as="template"
              enter="duration-300 ease-out"
              enter-from="opacity-0 scale-95"
              enter-to="opacity-100 scale-100"
              leave="duration-200 ease-in"
              leave-from="opacity-100 scale-100"
              leave-to="opacity-0 scale-95"
            >
              <DialogPanel class=" w-full max-w-2xl transform overflow-hidden rounded-2xl bg-white p-6 shadow-xl transition-all" :key="componentKey">
                <h1 class="text-center mb-10 text-2xl font-bold">¡Agrega un usuario!</h1>       
                <form @submit.prevent="submitForm" class="mx-auto w-full">
                  <div class="mb-5">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nombres</label>
                    <input type="text" id="name" v-model="formData.name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 ">
                    <p v-if="errors.name"  class="text-red-500 text-sm my-2">{{ errors.name[0] }}</p>
                  </div>
                  <div class="mb-5 ">
                    <label for="lastname" class="block mb-2 text-sm font-medium text-gray-900">Apellidos</label>
                    <input type="text" id="price" v-model="formData.lastname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 ">
                    <p v-if="errors.lastname" class="text-red-500 text-sm my-2">{{ errors.lastname[0] }}</p>
                  </div>
                  <div class="mb-5 ">
                    <label for="id_number" class="block mb-2 text-sm font-medium text-gray-900">N° de Identificación</label>
                    <input type="text" id="price" v-model="formData.id_number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 ">
                    <p v-if="errors.id_number" class="text-red-500 text-sm my-2">{{ errors.id_number[0] }}</p>
                  </div>
                  <div class="mb-5 ">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Correo Electrónico</label>
                    <input type="text" id="price" v-model="formData.email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 " novalidate>
                    <p v-if="errors.email" class="text-red-500 text-sm my-2">{{ errors.email[0] }}</p>
                  </div>
                  <div class="mb-5 ">
                    <label for="points_earned" class="block mb-2 text-sm font-medium text-gray-900">Puntos obtenidos</label>
                    <input type="text" id="price" v-model="formData.points_earned" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 ">
                    <p v-if="errors.points_earned" class="text-red-500 text-sm my-2">{{ errors.points_earned[0] }}</p>
                  </div>
                  <div class="flex justify-center w-full">
                      <button type="submit" class="text-white  bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm sm:w-auto px-5 py-2.5">Agregar</button>
                  </div>
                </form>
              </DialogPanel>
            </TransitionChild>
          </div>
        </div>        
      </Dialog>
    </TransitionRoot>
  </template>
  
<script setup lang="ts">
/**
 * Importaciones
 */
import { ref } from 'vue';
import { TransitionRoot, TransitionChild, Dialog, DialogPanel } from '@headlessui/vue';
import type { FormAddUser, FormErrors } from '@/interface/interfaces';
import { addUser } from '@/backend/crud';

/**
 * Se define una variable como key
 */
const componentKey = ref(0);

/**
 * Funcion para cambiar el valor de componentKey y asì forzar el re-renderizado de los modals
 */
const forceRerender = () => {
  componentKey.value += 1;
};


/**
 * Se define una variable como true para el estado del modal
 */
const isOpen = ref<boolean>(true);
/**
 * Se define una función para cerrar el modal, asignando isOpen como false
 */
function closeModal(): void {
  isOpen.value = false;
}

/**
 * Se define una lista de errores
 */
let errors = ref<FormErrors>({});

/**
 * Se define un formulario.
 */
const formData = ref<FormAddUser>({
  name: '',
  lastname: '',
  id_number: '',
  email:'',
  points_earned: 0,
});

/**
 * Se define la función para enviar el formulario a la api, obteniendo la respuesta y los errores.
 */
async function submitForm(): Promise<void> {
  errors.value = {};
  try {
    await addUser(formData.value);
    closeModal();
    window.location.reload();
  } catch (error: any) {
    errors = { ...error.response.data } || {};
    console.log(errors)
    forceRerender();
  }
}


</script>