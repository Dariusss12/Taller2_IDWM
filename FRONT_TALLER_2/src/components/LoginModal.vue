<template>
    <TransitionRoot appear :show="isOpen" as="template" static>
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
              <DialogPanel class="block w-full max-w-2xl transform overflow-hidden rounded-2xl bg-white p-6 shadow-xl transition-all sm:flex" :key="componentKey">
                <div class="w-full sm:w-1/2 mb-2">
                  <h1 class="text-center mb-10 text-2xl font-bold">¡Inicia sesión!</h1>       
                  <form @submit.prevent="submitForm" class="mx-auto w-full">
                    <div class="mb-5">
                      <label for="username" class="block mb-2 text-sm font-medium text-gray-900">Nombre de Usuario</label>
                      <input type="text" id="username" v-model="formData.username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 ">
                      <p v-if="errors.username"  class="text-red-500 text-sm my-2">{{ errors.username[0] }}</p>
                    </div>
                    <div class="mb-5 ">
                      <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Contraseña</label>
                      <input type="password" id="password" v-model="formData.password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 ">
                      <p v-if="errors.password" class="text-red-500 text-sm my-2">{{ errors.password[0] }}</p>
                    </div>
                    <p v-if="errors.credentials" class="text-red-500 text-sm mb-2">{{ errors.credentials }}</p>
                    <div class="flex justify-center w-full">
                        <button type="submit" class="text-white  bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm sm:w-auto px-5 py-2.5">Ingresar</button>
                    </div>
                  </form>
                </div>
                <div class="w-full sm:w-1/2 h-full">
                  <img src="/img/dumboLogo.png" class="mx-auto sm:p-5 max-h-80 ">
                </div>

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
import type { AdminCredentials, FormErrors } from '@/interface/interfaces';
import { login } from '@/backend/crud';

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
const formData = ref<AdminCredentials>({
  username: '',
  password: ''
});

/**
 * Se define la función para enviar el formulario a la api, obteniendo la respuesta y los errores.
 */
async function submitForm(): Promise<void> {
  errors.value = {};
  try {
    
    const response = await login(formData.value);
    localStorage.setItem('token',response.data.token)
    closeModal();
    window.location.reload();
  } catch (error: any) {
    errors = { ...error.response.data.error } || {};
    forceRerender();
  }
}


</script>