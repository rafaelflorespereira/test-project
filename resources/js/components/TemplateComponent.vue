<template>
  <div>
    <v-row>
      <v-col cols="12" sm="10" md="8">
        <v-text-field
          name="subject[]"
          label="Subject"
          placeholder="Subject with Header"
          outlined

          required
        ></v-text-field>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12" sm="10" md="8">
        <v-textarea 
          name="message[]" 
          label="Message"
          outlined
          auto-grow 
          placeholder="Message with Header"
          required
        ></v-textarea>
      </v-col>
    </v-row>
  </div>
</template>

<script>

export default {

}
</script>
