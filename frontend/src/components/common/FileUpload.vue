<template>
  <div>
    <v-text-field
      prepend-icon="attach_file"
      @click="selectFile"
      readonly
      :placeholder="fileName"
      :required="required"
      style="cursor: pointer"></v-text-field>
    <input type="file" :accept="accept" style="display: none" ref="fileInput" @change="onFileSelect" />
  </div>
</template>

<script>
  export default {
    name: "file-upload",
    props: {
      value: {
        type: [File, String]
      },
      accept: {
        type: String,
        default: "*"
      },
      label: {
        type: String,
        default: "Выберите файл..."
      },
      required: {
        type: Boolean,
        default: false
      }
    },
    methods: {
      selectFile() {
        this.$refs.fileInput.click();
      },
      onFileSelect(event) {
        const files = event.target.files;
        if (files[0] !== undefined) {
          this.$emit('input', files[0]);
        } else {
          this.$emit('input', null);
        }
      }
    },
    computed: {
      fileName() {
        if (this.value) {
          if (typeof this.value == 'string')
            return this.value;
          else
            return this.value.name;
        }
        return this.label;
      }
    }
  }
</script>

<style scoped>

</style>
