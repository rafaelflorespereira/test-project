<template>
  <v-app>
    <v-container>
      <v-simple-table>
        <thead>
          <tr>
            <th>Subjects</th>
            <th>Messages</th>
          </tr>
        </thead>
        <tbody>
          <div v-for="(subject, i) in subjects" :key="i">
            <tr v-for="(item, index) in subject" :key="index">
              <td> {{ item }}</td>
              <td> {{ messages[i][index] }}</td>
            </tr>
          </div>
        </tbody>
      </v-simple-table>
      {{ subjects}}
      {{messages}}
    </v-container>
  </v-app>
</template>

<script>
export default {
  props:["subjects", "messages"],
    mounted(){
    console.log(this.subjects, this.messages)
  }
}
</script>
