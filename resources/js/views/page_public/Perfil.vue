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
          <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
              <thead class="table-primary">
                <tr>
                  <th>ID</th>
                  <th>Nombre Completo</th>
                  <th>Teléfono</th>
                  <th>Fecha de Registro</th>
                  <!-- <th>Estado</th> -->
                </tr>
              </thead>
              <tbody>
                <tr v-for="ticket in tickets" :key="ticket.id">
                  <td>{{ ticket.id }}</td>
                  <td>{{ ticket.nombre_solicitante }}</td>
                  <td><a :href="'tel:' + ticket.telefono">{{ ticket.telefono }}</a></td>
                  <td>{{ ticket.fecha_registro }}</td>
                  <!-- <td>
                    <span class="badge" :class="{
                      'bg-success': ticket.estado === 'Completado',
                      'bg-warning': ticket.estado === 'En Proceso',
                      'bg-danger': ticket.estado === 'Pendiente',
                      'bg-secondary': ticket.estado === 'Cancelado'
                    }">
                      {{ ticket.estado }}
                    </span>
                  </td> -->
                </tr>
                <tr v-if="tickets.length === 0">
                  <td colspan="5" class="text-center py-5 text-muted">
                    <i class="bi bi-inbox fs-1 d-block mb-3"></i>
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

export default {
  setup() {
    const user = ref(JSON.parse(localStorage.getItem('userSession')) || {});
    const tickets = ref([]);
    const loading = ref(false);
    console.log(user.value);
    const fetchTickets = async () => {
      try {
        // console.log(user.value.id);
        const response = await axios.get(`/tickets?telefono=${user.value.telefono}`);
        console.log(response.data);
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


    onMounted(() => {
      fetchTickets();
    });

    return { user, tickets, updateProfile, loading };
  }
};
</script>
