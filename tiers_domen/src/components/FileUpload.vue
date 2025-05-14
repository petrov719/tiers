<template>
  <div class="file-upload">
    <div class="file-upload__area">
      <!-- <v-btn @click="toggleShow">Добавить файл</v-btn> -->
      <div v-if="file && !file.isUploaded">
        <input type="file" name="" id="" @change="handleFileChange($event)" />
        <div v-if="errors.length > 0">
          <div
            class="file-upload__error"
            v-for="(error, index) in errors"
            :key="index"
          >
            <span>{{ error }}</span>
          </div>
        </div>
      </div>
      <div>
      </div>
      <div v-if="file && file.isUploaded" class="upload-preview">
        <span>
          {{ file.name }}{{ file.isImage ? `.${file.fileExtention}` : "" }}
        </span>
        <v-img :src="file.url" v-if="file.isImage" class="file-image" alt="" />
        <div v-if="!file.isImage" class="file-extention">
          {{ file.fileExtention }}
        </div>
        <input type="file" name="" id="" @change="handleFileChange($event)" />
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "FileUpload",
  components: {
    // VImageInput,
  },
  props: {
    fileName:{
      type: String,
      default: null,
    },
    externalFile: {
      type: String,
      default: null,
    },
    maxSize: {
      type: Number,
      default: 5,
      required: true,
    },
    accept: {
      type: String,
      default: "image/*",
    },
  },
  data () {
    return {
      errors:[],
      upload:false,
      isLoading: false,
      uploadReady: true,
      file: {
        name: "",
        size: 0,
        type: "",
        fileExtention: "",
        url: "",
        isImage: false,
        isUploaded: false,
      },
    };
  },
  watch: {
    externalFile: {
      immediate: true,
      handler(newFile) {
        if (newFile) {
          const file = this.base64ToFile(newFile, "example.png", "image/png");
          this.handleExternalFile(file);
        }
      },
    },
  },
  methods: {
    base64ToFile(base64String, fileName, mimeType) {
      const byteString = atob(base64String.split(",")[0]); // Декодируем Base64
      const arrayBuffer = new ArrayBuffer(byteString.length);
      const uint8Array = new Uint8Array(arrayBuffer);
      for (let i = 0; i < byteString.length; i++) {
        uint8Array[i] = byteString.charCodeAt(i);
      }
      const blob = new Blob([uint8Array], { type: mimeType });
      return new File([blob], fileName, { type: mimeType });
    },
    pluginTashi() {
      this.$refs.fileInput.click();
    },
    handleExternalFile(file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        this.file = {
          name: this.fileName.split(".")[0],
          size: Math.round((file.size / 1024 / 1024) * 100) / 100,
          type: file.type,
          fileExtention: file.name.split(".").pop(),
          isImage: ["jpg", "jpeg", "png", "gif"].includes(file.name.split(".").pop()),
          url: e.target.result,
          isUploaded: true,
          rawFile: file,
        };
        this.sendDataToParent(this.file);
      };
      reader.readAsDataURL(file);
    },
    handleFileChange(e) {
      this.errors = [];
      if (e.target.files && e.target.files[0]) {
        if (this.isFileValid(e.target.files[0])) {
          const file = e.target.files[0],
            fileSize = Math.round((file.size / 1024 / 1024) * 100) / 100,
            fileExtention = file.name.split(".").pop(),
            fileName = file.name.split(".").shift(),
            isImage = ["jpg", "jpeg", "png", "gif"].includes(fileExtention);

          let reader = new FileReader();
          reader.addEventListener(
            "load",
            () => {
              this.file = {
                name: fileName,
                size: fileSize,
                type: file.type,
                fileExtention: fileExtention,
                isImage: isImage,
                url: reader.result,
                isUploaded: true,
                rawFile: file, // Передаем сам файл
              };
              this.sendDataToParent();
            },
            false
          );
          reader.readAsDataURL(file);
        } else {
          this.file.isUploaded = false;
          console.log("Invalid file");
        }
      }
    },
    toggleShow(){
      this.upload = !this.upload;
    },
    sendDataToParent() {
      this.$emit("file-uploaded", this.file);
    },
    isFileSizeValid(fileSize) {
      if (fileSize <= this.maxSize) {
        console.log("File size is valid");
      } else {
          this.errors.push(`Файл должен быть меньше чем ${this.maxSize} MB`);
      }
    },
    isFileTypeValid(fileExtention) {
      if (this.accept.split(",").includes(fileExtention)) {
        console.log("File type is valid");
      } else {
        this.errors.push(`Тип файла должен быть ${this.accept}`);
      }
    },
    isFileValid(file) {
      this.isFileSizeValid(Math.round((file.size / 1024 / 1024) * 100) / 100);
      this.isFileTypeValid(file.name.split(".").pop());
      if (this.errors.length === 0) {
        return true;
      } else {
        return false;
      }
    },
  },
};
</script>
<style>
.file-upload .file-upload__error {
  margin-top: 10px;
  color: #f00;
  font-size: 12px;
}
.file-upload .upload-preview {
  text-align: center;
}
.file-upload .upload-preview .file-image {
  width: 100%;
  height: 300px;
  object-fit: contain;
}
.file-upload .upload-preview .file-extension {
  height: 100px;
  width: 100px;
  border-radius: 8px;
  background: #ccc;
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 0.5em auto;
  font-size: 1.2em;
  padding: 1em;
  text-transform: uppercase;
  font-weight: 500;
}
.file-upload .upload-preview .file-name {
  font-size: 1.2em;
  font-weight: 500;
  color: #000;
  opacity: 0.5;
}

</style>