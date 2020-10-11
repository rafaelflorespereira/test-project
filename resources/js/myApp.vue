<template>
  <v-app>
    <v-container>
      <!-- @submit validate forms. -->
      <v-form 
        method="post" 
        action="/test-table" 
        enctype="multipart/form-data"
      >
      <input type="hidden" name="_token" :value="csrf">
        <v-card elevation="12">
          <v-row justify="center">
            <v-col cols="12" sm="10" md="8" lg="6">
                <v-card-title> Search in your SCV File</v-card-title>
                  <!-- ADD SCV file formats in the accept="" -->
                  <v-file-input
                    show-size
                    label="CSV File Input"
                    name="myFile"
                  ></v-file-input>
                <v-card-subtitle>
                  <p>{{ headerColumnExample }}</p> 
                  <p>{{ firstNameExample }}</p>
                </v-card-subtitle>

                <v-card-text
                  v-for="number in template"
                  :key="number"
                  >
                  Template {{ number }}
                  <component-template
                  ></component-template>
                </v-card-text>
                <v-btn @click="template += 1" outlined rounded small>New Template </v-btn>

                <v-divider></v-divider>
                <v-card-actions>
                  <v-row justify="center">
                    <v-btn type="submit" color="success">Submit</v-btn>
                  </v-row>
                </v-card-actions>
            </v-col>
          </v-row>
        </v-card>
      </v-form>
    </v-container>
  </v-app>
</template>

<script>
import template from './components/TemplateComponent.vue'
  export default {
    components: {
      componentTemplate: template
    },
    data: () => ({
      template: 1,
      headerColumnExample: 'The Header must be in {{ header_column }} format',
      firstNameExample: 'For example: His first name is: {{ First Name }}',
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    })
  }
</script>