<template>
  <div>
    <div class="w-100 h-100 image-upload position-relative bg-cdbb d-flex justify-content-center align-items-center">
      <i v-if="hasImg()" @click="removeImg" class="h-100 text-danger position-absolute top-0 right-0 mt-2 mr-2 fas fa-trash"></i>
      <img v-if="hasImg()" class="w-100 h-100 object-fit-cover position-absolute" :src="imageSrc">
      <div class="input-wrapper">
          <label v-show="!hasImg()" :for="inputId" class="btn btn-primary"><i class="fas fa-upload mr-2"></i>
            <span class="v-align-middle">
              Kies een foto
            </span>
          </label>
          <input ref="inputEl" @change="previewImg" type="file" accept="image/*" :name="name" class="d-none" :id="inputId">
      </div>
    </div>
    <div class="form-check">
      <input type="checkbox" class="form-check-input" v-model="isPrivate" :id="`private-${uploadId}`">
      <label class="form-check-label" :for="`private-${uploadId}`">Prive</label>
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
    uploadId: String,
  },
  data: () => ({
    imageSrc: '',
    imageFile: {},
    isPrivate: false,
  }),
  computed: {
    // Generate random id for input and label binding
    inputId: function() {
      return `${this.name}-input-${Date.now()}${Math.random() * 1000}`;
    },
  },
  // Set initial image
  mounted: function() {
    this.imageSrc = this.image;
  },
  // Watch for changes and send change event with new data
  watch: {
    imageFile: function(newFile) {
      this.$emit('change', { isPrivate: this.isPrivate, id: this.uploadId, file: newFile });
    },
    isPrivate: function(newPrivate) {
      this.$emit('change', { isPrivate: newPrivate, id: this.uploadId, file: this.imageFile });
    },
  },
  methods: {
    // Reset image
    removeImg: function() {
      this.imageSrc = '';
      this.imageFile = {};
      this.$refs.inputEl.value = '';
    },
    // Read out file as data image to show preview
    previewImg: function(e) {
      const file = e.target.files[0];
      if(!file) return;

      const reader = new FileReader();
      reader.onload = e => {
        this.imageSrc = e.target.result;
        this.imageFile = file;
      };

      reader.readAsDataURL(file);
    },
    hasImg: function() {
      return this.imageSrc.length > 0;
    },
  },
}
</script>
