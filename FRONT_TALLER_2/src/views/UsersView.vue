<template>
    <ConfirmationModal 
        v-if="showConfirmationModal" 
        @close="showConfirmationModal = false, idModal = '', nameModal = '', lastnameModal = ''" 
        :id=idModal
        :name=nameModal
        :lastname=lastnameModal
         ></ConfirmationModal>
|   <EditModal 
        v-if="showEditModal" 
        @close="showEditModal = false, idModal = '', nameModal = '', lastnameModal = '', emailModal = '', pointsEarnedModal = 0" 
        :id=idModal
        :name=nameModal
        :lastname=lastnameModal
        :email=emailModal
        :points_earned=pointsEarnedModal
         ></EditModal>
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="py-3 px-3 mx-auto">
                <div class="relative max-w-xs">
                    <label for="search" class="sr-only"> Search </label>
                    <input
                        v-model="searchTerm"
                        type="text"
                        name="search"
                        class="block w-full p-3 pl-10 text-sm border-gray-200 rounded-md border"
                        placeholder="Search..."
                    />
                    <div
                        class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 text-gray-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                            />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="p-3 w-full inline-block align-middle">
                <div class="overflow-auto border rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    scope="col"
                                    class="flex items-center px-6 py-3 text-xs font-bold text-left text-gray-500 uppercase"
                                >
                                    ID
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-xs font-bold text-left text-gray-500 uppercase"
                                >
                                    <span class="inline-flex items-center">
                                        Nombres
                                    </span>
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-xs font-bold text-left text-gray-500 uppercase"
                                >
                                    <span class="inline-flex items-center">
                                        Apellidos
                                    </span>
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-xs font-bold text-left text-gray-500 uppercase"
                                >
                                    <span class="inline-flex items-center">
                                        N° de Identificación
                                    </span>
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-xs font-bold text-left text-gray-500 uppercase"
                                >
                                    <span class="inline-flex items-center">
                                        Correo Electrónico
                                    </span>
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-xs font-bold text-left text-gray-500 uppercase"
                                >
                                    Cant. Puntos
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 w-[100px]"
                                >        
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 w-[100px]"
                                >                      
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr v-for="user in users" :key="user.id">
                                <td
                                    class="px-6 py-4 text-sm font-medium text-gray-800 whitespace-nowrap"
                                >
                                    {{  user.id }}
                                </td>
                                <td
                                    class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap"
                                >
                                    {{  user.name }}
                                </td>
                                <td
                                    class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap"
                                >
                                    {{  user.lastname }}
                                </td>
                                <td
                                    class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap"
                                >
                                    {{  user.id_number }}
                                </td>
                                <td
                                    class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap"
                                >
                                    {{  user.email }}
                                </td>
                                <td
                                    class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap"
                                >
                                    {{  user.points_earned.toLocaleString('de-DE') }}
                                </td>
                                <td
                                    class="px-6 py-4 text-sm font-medium text-center whitespace-nowrap"
                                >
                                    <button @click="openEditModal(user.id,user.name,user.lastname,user.email,user.points_earned)" class="text-green-500 hover:text-green-400">
                                        Editar
                                    </button>
                                </td>
                                <td
                                    class="px-6 py-4 text-sm font-medium text-center whitespace-nowrap"
                                >
                                    <button @click="openConfirmationModal(user.id,user.name,user.lastname)" class="text-red-500 hover:text-red-400">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup lang="ts">
import { ref, onMounted, watch } from 'vue';
import type { User } from '../interface/interfaces';
import {getUsers} from '../backend/crud';
import ConfirmationModal from '@/components/ConfirmationModal.vue';
import EditModal from '@/components/EditModal.vue';

const showConfirmationModal = ref(false);
const showEditModal = ref(false);

let idModal = '';
let nameModal = '';
let lastnameModal = '';
let emailModal = '';
let pointsEarnedModal = 0;

function openConfirmationModal(id: number, name:string, lastname: string) {
    showConfirmationModal.value = true;
    idModal = id.toString();
    nameModal = name;
    lastnameModal = lastname;
}

function openEditModal(id: number, name:string, lastname: string, email: string, pointsEarned: number) {
    showEditModal.value = true;
    idModal = id.toString();
    nameModal = name;
    lastnameModal = lastname;
    emailModal = email;
    pointsEarnedModal = pointsEarned;
}

const users = ref<User[]>([]);

const searchTerm = ref<string>('');

// Configurar un watcher para estar atento a los cambios en searchTerm
watch(searchTerm, (newValue, oldValue) => {
  // Filtrar los usuarios según el término de búsqueda
  if (newValue === '') {
    // Si el término de búsqueda está vacío, mostrar todos los usuarios
    users.value = originalUsers;
  } else {
    // Filtrar los usuarios según el término de búsqueda
    const filteredUsers = originalUsers.filter(user =>
    user.id_number.toLowerCase().includes(newValue) || user.email.toLowerCase().includes(newValue.toLowerCase())
    );

    // Actualizar users con el resultado filtrado
    users.value = filteredUsers;
  }
});

let originalUsers: User[] = [];

onMounted(async () => {
  try {
    const response = await getUsers();
    users.value = response.data.users;
    originalUsers = response.data.users;
    
  } catch (error) {
    console.error('Error fetching data:', error);
  }
});
</script>