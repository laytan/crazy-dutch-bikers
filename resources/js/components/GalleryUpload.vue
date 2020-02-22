<template>
  <div>
    <form @submit.prevent="submit">
      <div :class="rowClass">
        <div :class="itemClass" v-for="(image, i) in images" :key="i">
          <image-upload class="mt-2" :upload-id="i.toString()" @change="onUploadChanged"></image-upload>
        </div>
      </div>
      <button @click.prevent="addMore(addAmount)" class="btn btn-link text-center d-block w-100 mt-4">Meer foto's uploaden</button>
      <hr class="border-cdblg mb-4">
      <div class="d-flex align-items-stretch">
        <button :disabled="isUploading()" type="submit" class="btn btn-primary d-flex align-items-center">
          <span>Uploaden</span>
          <i v-if="isUploading()" class="fas fa-spinner fa-spin ml-2"></i>
        </button>
        <progress class="ml-3 mb-0 w-100" v-if="isUploading()" min="0" :max="uploadProgress.max" :value="uploadProgress.progress"></progress>
      </div>
    </form>
  </div>
</template>

<script>
import ImageUpload from './ImageUpload';

export default {
  props: {
    initial: {
      type: Number,
      default: 3,
    },
    rowClass: {
      type: String,
      default: 'row',
    },
    itemClass: {
      type: String,
      default: 'col-12 col-md-6 col-xl-4',
    },
    addAmount: {
      type: Number,
      default: 3,
    },
    // Gallery title
    gallery: {
      type: String,
      required: true,
    },
    apiToken: {
      type: String,
      required: true,
    },
  },
  // Add the initial uploads
  beforeMount: function() {
    this.addMore(this.initial);
  },
  data: () => ({
    images: [],
    uploadProgress: {
      max: 0,
      progress: 0,
    },
  }),
  components: {
    ImageUpload,
  },
  methods: {
    // Add the amount specified of objects 
    addMore: function(add) {
      const l = this.images.length;
      for (let i = l; i < l + add; i++) {
        this.images.push({});
      }
    },
    // Check if we are uploading
    isUploading() {
      return this.uploadProgress.max !== this.uploadProgress.progress;
    },
    submit: function() {
      // Filter out empty images
      this.images = this.images.filter(image => Object.entries(image).length !== 0 );
      // Set up progress bar
      this.uploadProgress.max = this.images.length;
      this.uploadProgress.progress = 0;
      // Keep track off the indexes we have gotten a response from
      const uploaded = [];
      this.images.forEach((image, i) => {
        // Construct body as FormData so we can easily use files
        const body = new FormData();
        body.append('image', image.file);
        body.append('is_private', image.isPrivate ? 1 : 0);
        body.append('gallery', this.gallery);

        fetch('/api/pictures', {
          headers: {
            "Accept": "application/json, text-plain, */*",
            "Authorization": `Bearer ${this.apiToken}`,
          },
          method: 'POST',
          body: body,
        })
        .then(response => {
          if(!response.ok) {
            console.error(response);
          }
        })
        .catch(console.error)
        .finally(() => {
          this.uploadProgress.progress++;
          uploaded.push(i);
          if(uploaded.length === this.images.length) {
            // Filter out all images we have uploaded
            this.images = this.images.filter((_, i) => !uploaded.includes(i));
          }
        });
      });
    },
    // Update our data when an imageupload sends a change event
    onUploadChanged({ id, isPrivate, file }) {
      this.images[id] = { isPrivate, file };
    },
  },
}
</script>
