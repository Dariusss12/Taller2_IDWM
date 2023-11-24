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
                      <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm sm:w-auto px-5 py-2.5">Ingresar</button>
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
import { ref } from 'vue';
import { TransitionRoot, TransitionChild, Dialog, DialogPanel } from '@headlessui/vue';
import type { AdminCredentials, FormErrors } from '@/interface/interfaces';
import { login } from '@/backend/crud';


const componentKey = ref(0);

const forceRerender = () => {
  componentKey.value += 1;
};



const isOpen = ref<boolean>(true);
function closeModal(): void {
  isOpen.value = false;
}


let errors = ref<FormErrors>({});

const formData = ref<AdminCredentials>({
  username: '',
  password: ''
});


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