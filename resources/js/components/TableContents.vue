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
                  <th>Send E-mail</th>
                </tr>
              </thead>
              <tbody >
                <tr v-for="(contact, index) in parsedContacts">
                  <td>{{ contact.subject }}</td>
                  <td>{{ contact.message }}</td>
                  <td>
                    <v-tooltip bottom>
                      <template v-slot:activator="{ on, attrs }">
                        <v-btn 
                          icon
                          color="green"                
                          v-on="on"
                          v-bind="attrs" 
                          @click="
                            sendMail(contact.subject, 
                              contact.message, 
                                parsedEmails[index])
                          "
                        >
                          <v-icon>
                            mdi-email-send-outline
                          </v-icon>
                        </v-btn>
                      </template>
                      <span>Send to {{ parsedEmails[index] }}</span>
                    </v-tooltip>
                  </td>
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
  //get the content from subjects and messages
  props:["contacts", "emails"],
    mounted(){
    this.parsedContacts = JSON.parse(this.contacts)
    this.parsedEmails   = JSON.parse(this.emails)
  },
  data:() => {
    return {
      parsedContacts: [],
      parsedEmails: [],
    }
  },
  methods: {
    sendMail(subject, message, email) {
      window.location.href = '/send-mail/'+subject+'/'+message+'/'+email
    }
  }
}
</script>
