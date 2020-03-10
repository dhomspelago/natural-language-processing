<template>
  <div class="custom-wrapper">
    <div class="d-flex justify-content-center">
      <p class="heading-text text-uppercase">Natural Language Processing</p>
    </div>
    <div class="content">
      <div class="d-flex justify-content-center mb-3">
        <textarea class="text-area w-100" rows="10" v-model="text"></textarea>
      </div>
      <div class="d-flex justify-content-center mb-3 align-items-center">
        <label class="label-text mr-2">Select Type:</label>
        <select class="type" v-model="type">
          <option value="">Select Type...</option>
          <option value="summarize">Summarize</option>
          <option value="sentiment">Sentiment</option>
          <option value="language">Language</option>
          <option value="categorize">Categorize</option>
        </select>
      </div>
      <div class="d-flex justify-content-center">
        <button class="btn input-button" @click="analyze" :disabled="disable">{{ btnName }}</button>
      </div>
    </div>
    <div class="result" v-if="resultBool">
      <span>Result:</span>
      <div>
        {{ result }}
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'content',
    data () {
      return {
        type: '',
        text: '',
        disable: false,
        btnName: 'Analyze',
        result: '',
        resultBool: false,
        errors: null
      }
    },
    mounted () {

    },
    methods: {
      analyze () {
        this.disable = true
        this.btnName = 'Loading.....'
        axios.post('/api/analyze', {
          'type': this.type,
          'text': this.text
        }).then((response) => {
          this.disable = false
          this.btnName = 'Analyze'
          this.resultBool = true
        }).catch((errors) => {
          this.disable = false
          this.btnName = 'Analyze'
          swal('Opppsss! Something went wrong!', 'The text and type field are required', 'error')
        })
      },
    }
  }
</script>

<style scoped>

</style>
