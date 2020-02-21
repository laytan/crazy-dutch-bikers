<template>
  <div>
    <div :class="(invalid ? 'is-invalid' : '') + ' w-100 h-100 image-upload position-relative bg-cdbb d-flex justify-content-center align-items-center'">
      <i v-if="showTrash()" @click="removeImgOrEl" class="h-100 text-danger position-absolute top-0 right-0 mt-2 mr-2 fas fa-trash"></i>
      <img class="w-100 h-100 object-fit-cover position-absolute" :src="imageSrc">
      <div class="input-wrapper">
          <label v-show="!hasImg()" :for="inputId" class="btn btn-primary"><i class="fas fa-upload mr-2"></i>
            <span class="v-align-middle">
              Kies een foto
            </span>
          </label>
          <input @change="previewImg" type="file" accept="image/*" name="images[]" class="d-none" :id="inputId">
      </div>
    </div>
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
    canRemove: {
      type: Boolean,
      default: false,
    },
  },
  data: () => ({
    imageSrc: '',
  }),
  computed: {
    inputId: function() {
      return `${this.name}-input-${Date.now()}${Math.random() * 1000}`;
    },
  },
  mounted: function() {
    this.imageSrc = this.image;
  },
  methods: {
    removeImgOrEl: function() {
      if(this.imageSrc.length > 0) {
        this.imageSrc = '';
      } else if(this.canRemove) {
        this.$destroy();
        this.$el.parentNode.removeChild(this.$el);
      }
    },
    previewImg: function(e) {
      const file = e.target.files[0];
      if(!file) return;

      const reader = new FileReader();
      reader.onload = e => {
        this.imageSrc = e.target.result;
      };

      reader.readAsDataURL(file);
    },
    hasImg: function() {
      return this.imageSrc.length > 0;
    },
    showTrash: function() {
      return this.hasImg() || this.canRemove;
    }
  },
}
</script>

<style scoped>
.input-wrapper, i {
  z-index: 5;
  cursor: pointer;
}
</style>
