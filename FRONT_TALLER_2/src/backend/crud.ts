import api from '../services/api';
import type { AdminCredentials } from '@/interface/interfaces';
import type { User, FormAddUser, FormEditUser } from '@/interface/interfaces';

export async function login(data:AdminCredentials) {
  const response = await api.post('/login', data);
  return response;
}

export async function logout(){
  // Obtén el token del localStorage
  const token = localStorage.getItem('token');

  // Verifica si el token está presente
  if (!token) {
    console.error('No se encontró el token en localStorage');
    return false;
  }

  try {
    // Realiza la solicitud de logout con el token en el encabezado
    const response = await api.post('/logout', null, {
      headers: {
        Authorization: `Bearer ${token}`
      }
    });

    // Si la solicitud tiene éxito, realiza otras acciones según sea necesario
    // ...
    return response; // Indica que el logout fue exitoso

  } catch (error) {
    console.error('Error al realizar el logout:', error);
    return false; // Indica que hubo un error durante el logout
  }
}

export async function getUsers() {
  const response = await api.get('/users',{
    headers:{
      Authorization: `Bearer ${localStorage.getItem('token')}`
    }
  });
  return response;
}

export async function addUser(data: FormAddUser) {
  const response = await api.post('/users',data,{
    headers:{
      Authorization: `Bearer ${localStorage.getItem('token')}`
    }
  });
  return response;
}

export async function editUser(data: FormEditUser, id: string) {
  const response = await api.put(`/users/${id}`,data,{
    headers:{
      Authorization: `Bearer ${localStorage.getItem('token')}`
    }
  });
  return response;
}

export async function deleteUser(id:String) {
  const response = await api.delete(`/users/${id}`,{
    headers:{
      Authorization: `Bearer ${localStorage.getItem('token')}`
    }
  });
  return response;
}


