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
              <DialogPanel class=" w-full max-w-2xl transform overflow-hidden rounded-2xl bg-white p-6 shadow-xl transition-all">
                <div v-if="!message">
                    <h1 class="text-center text-3xl font-bold">¿Estás seguro que deseas eliminar el usuario {{ props.name }} {{ props.lastname }}?</h1>
                    <div class="w-full text-center">
                        <button @click="deleteUserById(props.id || '0')" class="bg-green-500 hover:bg-green-400 py-1 mx-4 mt-7 rounded-lg text-white text-xl font-bold w-[80px]">Si</button>
                        <button @click="closeModal" class="bg-red-500 hover:bg-red-400 py-1 mx-4 mt-7 rounded-lg text-white text-xl font-bold w-[80px]">No</button>
                    </div>
                </div>
                <div v-else>
                    <h1 class="text-center text-3xl font-bold">{{ message }}</h1>
                </div>
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
import { deleteUser } from '@/backend/crud';

const isOpen = ref<boolean>(true);
function closeModal(): void {
  isOpen.value = false;
}

const props = defineProps({
    id: String,
    name: String,
    lastname: String
});

const message = ref('')
function delayWithPromise(milliseconds: number): Promise<void> {
  return new Promise((resolve) => {
    setTimeout(() => {
      resolve();
    }, milliseconds);
  });
}

async function deleteUserById(id: string){
    const response = await deleteUser(id);
    console.log(response)
    message.value = response.data
    await delayWithPromise(1000);
    closeModal();
    window.location.reload();
    
}

</script>