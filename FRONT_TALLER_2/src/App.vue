<script setup lang="ts">
import { ref, onMounted} from 'vue';
import { RouterView } from 'vue-router'
import LoginModal from './components/LoginModal.vue';
import AddModal from './components/AddModal.vue';
import {logout} from '@/backend/crud'

const showLoginModal = ref(false);
const showAddModal = ref(false);
const tokenExist = ref(false);

function openLoginModal() {
  showLoginModal.value = true;
}
function openAddModal() {
  showAddModal.value = true;
}

onMounted(async () => {
  if(localStorage.getItem('token') == null){
    showLoginModal.value = true;
  }
  else{
    showLoginModal.value = false;
    tokenExist.value = true;
  }

});

async function logoutAdmin() {
  try {
    if(localStorage.getItem('token') != null){
      await logout();
      localStorage.removeItem('token');
      window.location.reload();
    }
  } catch (error: any) {
    console.log('Hubo un error', error.response.data);
  }

}

</script>

<template>
  <div>
    <LoginModal v-if="showLoginModal" @close="showLoginModal = false"></LoginModal>
    <AddModal v-if="showAddModal" @close="showAddModal = false"></AddModal>
    <header>
      <div>
        <nav class="bg-[#00AD5A]">
          <div class="max-w-full flex flex-wrap items-center justify-between mx-auto p-4">
            <button @click="openAddModal" v-if="tokenExist" class="font-bold text-white p-2 rounded-lg text-sm sm:text-base bg-green-500 hover:bg-green-600">
              AGREGAR USUARIO
            </button>
            <div class="hidden sm:flex mr-[72px]">
              <img src="/img/dumboLogo.png" class="h-[40px] self-center">
              <img src="/img/dumbo.png" class="h-[40px] ml-1 self-center">
            </div>
            <div v-if="tokenExist" class="block w-auto" id="navbar-default">           
              <button @click="logoutAdmin" class="flex items-center space-x-3 text-sm sm:text-base hover:text-gray-200 text-white">
                Cerrar Sesión
              </button>
            </div>
            <button v-if="!tokenExist" @click="openLoginModal" class="font-bold text-white p-2 rounded-lg text-sm sm:text-base bg-green-500 hover:bg-green-600">
              Inicia Sesión
            </button>
          </div>
        </nav>
      </div>
    </header>
    <RouterView v-if="tokenExist"/>

  </div>
</template>

