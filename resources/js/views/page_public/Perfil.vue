<template>
  <section class="py-5 bg-light">
    <div class="container">
      <h2 class="display-5 fw-bold text-primary mb-5">Mi Perfil</h2>

      <!-- Formulario de edición -->
      <div class="card shadow mb-5">
        <div class="card-body">
          <form @submit.prevent="updateProfile">
            <div class="mb-3">
              <label class="form-label">Nombre Completo</label>
              <input type="text" v-model="user.nombre_completo" class="form-control" required />
            </div>
            <div class="mb-3">
              <label class="form-label">Correo</label>
              <input type="email" v-model="user.email" class="form-control" required />
            </div>
            <div class="mb-3">
              <label class="form-label">Teléfono</label>
              <input type="text" v-model="user.telefono" class="form-control" required />
            </div>
            <button type="submit" class="btn btn-primary" :disabled="loading">
              {{ loading ? 'Guardando...' : 'Actualizar Perfil' }}
            </button>
          </form>
        </div>
      </div>

      <!-- Tabla de Tickets -->
      <div class="card shadow">
        <div class="card-body p-0">
          <div class="flex justify-end p-2">
            <button @click="exportExcel" class="btn btn-success">Exportar a Excel</button>
          </div>
          <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse border border-gray-300">
              <thead class="bg-blue-200">
                <tr>
                  <th class="border px-4 py-2">ID</th>
                  <th class="border px-4 py-2">Nombre Completo</th>
                  <th class="border px-4 py-2">Teléfono</th>
                  <th class="border px-4 py-2">Fecha de Registro</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="ticket in tickets" :key="ticket.id" class="hover:bg-gray-100">
                  <td class="border px-4 py-2">{{ ticket.id }}</td>
                  <td class="border px-4 py-2">{{ ticket.nombre_solicitante }}</td>
                  <td class="border px-4 py-2">
                    <a :href="'tel:' + ticket.telefono" class="text-blue-600 hover:underline">
                      {{ ticket.telefono }}
                    </a>
                  </td>
                  <td class="border px-4 py-2">{{ ticket.fecha_registro }}</td>
                </tr>
                <tr v-if="tickets.length === 0">
                  <td colspan="4" class="text-center py-5 text-gray-500">
                    No hay tickets disponibles
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import * as XLSX from 'xlsx';
import { saveAs } from 'file-saver';

export default {
  setup() {
    // Función helper para obtener userSession de forma segura
    const getUserSession = () => {
      try {
        const sessionData = localStorage.getItem('userSession');
        if (!sessionData) return {};
        try {
          return JSON.parse(sessionData) || {};
        } catch (e) {
          console.warn('Error al parsear userSession:', e);
          localStorage.removeItem('userSession');
          return {};
        }
      } catch (e) {
        console.error('Error al leer userSession:', e);
        return {};
      }
    };
    const user = ref(getUserSession());
    const tickets = ref([]);
    const loading = ref(false);

    const fetchTickets = async () => {
      try {
        const response = await axios.get(`/tickets?telefono=${user.value.telefono}`);
        tickets.value = response.data || [];
      } catch (error) {
        console.error('Error fetching tickets:', error);
      }
    };

    const updateProfile = async () => {
      loading.value = true;
      try {
        const response = await axios.put(`/users/${user.value.id}`, {
          nombre_completo: user.value.nombre_completo,
          email: user.value.email,
          telefono: user.value.telefono,
        });
        localStorage.setItem('userSession', JSON.stringify(response.data));
        alert('Perfil actualizado correctamente');
      } catch (error) {
        console.error(error);
        alert('Error actualizando perfil');
      } finally {
        loading.value = false;
      }
    };

    const exportExcel = () => {
      if (tickets.value.length === 0) {
        alert('No hay datos para exportar');
        return;
      }
      const ws = XLSX.utils.json_to_sheet(tickets.value);
      const wb = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(wb, ws, 'Tickets');
      const wbout = XLSX.write(wb, { bookType: 'xlsx', type: 'array' });
      saveAs(new Blob([wbout], { type: 'application/octet-stream' }), 'tickets.xlsx');
    };

    onMounted(() => {
      fetchTickets();
    });

    return { user, tickets, loading, updateProfile, exportExcel };
  },
};
</script>
