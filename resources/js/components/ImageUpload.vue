<template>
  <div>
    <div :class="(invalid ? 'is-invalid' : '') + ' w-100 h-100 image-upload position-relative bg-cdbb d-flex justify-content-center align-items-center'">
      <i v-if="hasImg()" @click="removeImg" class="h-100 text-danger position-absolute top-0 right-0 mt-2 mr-2 fas fa-trash"></i>
      <img class="w-100 h-100 object-fit-cover position-absolute" :src="imageSrc">
      <div class="input-wrapper">
          <label v-show="!hasImg()" :for="inputId" class="btn btn-primary"><i class="fas fa-upload mr-2"></i>
            <span class="v-align-middle">
              Kies een foto
            </span>
          </label>
          <input ref="inputEl" @change="previewImg" type="file" accept="image/*" :name="name" class="d-none" :id="inputId">
      </div>
    </div>
    <input :id="`private-${uploadId}`" type="checkbox" @click="isPrivate = !isPrivate" :checked="isPrivate">
    <label :for="`private-${uploadId}`">Prive?</label>
    <div v-if="invalid" class="text-danger">
      Deze foto is ongeldig
    </div>
  </div>
</template>

<script>
export default {
  props: {
    image: {
      type: String,
      default: '',
    },
    name: {
      type: String,
      default: 'image',
    },
    invalid: {
      type: Boolean,
      default: false,
    },
    uploadId: String,
  },
  data: () => ({
    imageSrc: '',
    isPrivate: false,
  }),
  computed: {
    inputId: function() {
      return `${this.name}-input-${Date.now()}${Math.random() * 1000}`;
    },
  },
  mounted: function() {
    this.imageSrc = this.image;
  },
  watch: {
    isPrivate: function(val) {
      this.$emit('changePrivacy', { val, id: this.uploadId });
    },
  },
  methods: {
    removeImg: function() {
      this.imageSrc = '';
      this.$refs.inputEl.value = '';
      this.$emit('removedImage', { id: this.uploadId });
    },
    previewImg: function(e) {
      const file = e.target.files[0];
      if(!file) return;

      const reader = new FileReader();
      reader.onload = e => {
        this.imageSrc = e.target.result;
        this.$emit('image', { file, isPrivate: this.isPrivate, id: this.uploadId });
      };

      reader.readAsDataURL(file);
    },
    hasImg: function() {
      return this.imageSrc.length > 0;
    },
  },
}
</script>

<style scoped>
.input-wrapper, i {
  z-index: 5;
  cursor: pointer;
}
</style>
