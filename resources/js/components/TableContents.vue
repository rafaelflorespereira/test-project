<template>
  <v-app>
    <v-container>
      <v-row justify="center">
        <v-col cols="12" md="10">
          <v-card
          elevation="12">
          <v-card-title> Table of Contents </v-card-title>
            <v-simple-table>
              <thead>
                <tr>
                  <th>Subjects</th>
                  <th>Messages</th>
                </tr>
              </thead>
              <tbody v-for="(subject, index) in subjects">
                <tr v-for="(item, i) in subject">
                  <td>{{ item }}</td>
                  <td>{{ messages[index][i] }}</td>
                </tr>
              </tbody>
            </v-simple-table>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </v-app>
</template>

<script>
export default {
  props:["subjects", "messages"],
    mounted(){
    this.subjects = JSON.parse(this.subjects)
    this.messages = JSON.parse(this.messages)
  }
}
</script>
