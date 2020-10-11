<template>
  <v-app>
    <v-container>
      <!-- @submit validate forms. -->
      <v-form 
        method="post" 
        action="/test-table" 
        enctype="multipart/form-data"
        @submit="checkForm"
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
                  :error-messages="fileErrors"
                  required
                  @input="$v.file.$touch()"
                  @blur="$v.file.$touch()"
                  v-model="file"
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

              <v-tooltip bottom>
                <template v-slot:activator="{ on, attrs }">
                  <v-btn 
                    @click="template += 1" 
                    outlined 
                    rounded 
                    small
                    v-on="on"
                    v-bind="attrs"
                  >New Template </v-btn>
                </template>
                <span>Create new template based on the first one</span>
              </v-tooltip>
              
              
              <v-tooltip bottom>
                <template v-slot:activator="{ on, attrs }">
                  <v-btn 
                    @click="subtractTemplate" 
                    color="red"
                    outlined 
                    rounded 
                    small
                    v-on="on"
                    v-bind="attrs"
                  >Remove</v-btn>
                </template>
                <span>Remove last but one</span>
              </v-tooltip>
              
              <v-divider></v-divider>
              <v-card-actions>
                <v-row justify="center">
                  <v-btn type="submit" @click="submit" color="success">Submit</v-btn>
                </v-row>
              </v-card-actions>
            </v-col>
          </v-row>
        </v-card>
      </v-form>

      <!-- !FORM ERROR DIALOG -->
      <v-dialog
        v-model="dialog"
        max-width="290"
      >
      <v-card>

      <v-card-title class="headline">
        Form fill Error!
        </v-card-title>
        <v-card-text>
          All the contents need to be filled before sending the form
        </v-card-text>
          <v-card-actions>
            <v-btn
              text
              tile
              @click="dialog = false"
            >
              Ok
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-container>
  </v-app>
</template>

<script>
import { validationMixin } from 'vuelidate'
import { required } from 'vuelidate/lib/validators'
import template from './components/TemplateComponent.vue'
  export default {
    props: ['error'],
    mixins: [validationMixin],
    validations: {
      file: {required}
    },
    components: {
      componentTemplate: template
    },
    data: () => ({
      template: 1,
      headerColumnExample: 'The Header must be in {{ header_column }} format',
      firstNameExample: 'For example: His first name is: {{ First Name }}',
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      valid: true,
      file: null,
      dialog: false
    }),
    computed: {
      fileErrors() {
        const errors = []
        if (!this.$v.file.$dirty) return errors
          !this.$v.file.required && errors.push('File is required')
        return errors
      }
    },
    methods: {
      submit() {
        this.$v.file.touch()
      },
      checkForm(e){
        if(this.$v.file.$invalid) {
          e.preventDefault()
        }
      },
      subtractTemplate() {
        if (this.template > 1 ) this.template -= 1
      }
    },
    created() {
      if(this.error) this.dialog = true
    }
  }
</script>