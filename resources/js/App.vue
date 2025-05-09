<template>
  <head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  </head>
  <div id="app">
    <h1>Hello world!</h1>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="document in documents" :key="document.id">
          <td>{{ document.id }}</td>
          <td>{{ document.name }}</td>
          <td>
            <span>
              {{ document.active ? 'Active' : 'Inactive' }}
            </span>
          </td>
          <td>
            <button v-if="document.can_download">
              <i class="fas fa-download"></i> 
            </button>
            <span v-else>
             <i class="fas fa-ban"></i> 
            </span>
          </td>
        </tr>
      </tbody>
    </table>
    <br>
    <button @click="erakutsi = !erakutsi">Gehitu dokumentua</button>
    <div v-show="erakutsi">
      <form>
        <label>Izena</label>
        <input type="text"/>
        <br>
        <label>Path</label>
        <input type="text"/>
        <br>
        <label>Deskargatu</label>
        <input type="checkbox"/>
        <br>
        <label>Aktibatu</label>
        <input type="checkbox"/>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: 'App',
  data() {
    return {
      erakutsi: false,
      documents: [
        {
          id: 1,
          name: 'Dokumentua 1',
          path: 'https://pdfobject.com/pdf/sample.pdf',
          can_download: false,
          active: true
        },
        {
          id: 2,
          name: 'Dokumentua 2',
          path: 'https://pdfobject.com/pdf/sample.pdf',
          can_download: true,
          active: true
        }
      ]
    }
  }
}
</script>

<style>

</style>