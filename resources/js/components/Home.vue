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
        </select>
      </div>
      <div class="d-flex justify-content-center">
        <button class="btn input-button" @click="analyze" :disabled="disable">{{ btnName }}</button>
      </div>
    </div>
    <div class="result" v-if="resultBool">
      <span>Result:</span>
      <div v-if="type === 'summarize'">
        {{ result }}
      </div>
      <div v-if="type === 'sentiment'">
        <i class="far fa-smile"></i>
        <i class="far fa-frown"></i>
        <i class="far fa-meh"></i>
      </div>
      <div v-if="type === 'language'">

      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'content',
    data() {
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
    mounted() {

    },
    methods: {
      analyze() {
        this.resultBool = false
        this.disable = true
        this.btnName = 'Loading.....'
        this.result = null
        axios.post('/api/analyze', {
          'type': this.type,
          'text': this.text
        }).then((response) => {
          this.disable = false
          this.btnName = 'Analyze'
          this.resultBool = true
          this.returnResult(response)
        }).catch((errors) => {
          this.disable = false
          this.btnName = 'Analyze'
          swal('Opppsss! Something went wrong!', 'The text and type field are required', 'error')
        })
      },
      returnResult(response) {
        console.log(response.data)
        switch (this.type) {
          case 'summarize':
            return this.result = response.data
          case 'sentiment':
            return ''
          case "language":
            return ''
        }
      },
      getSentiment(sentiment) {
        switch (sentiment) {
          case 'neg':
            break
        }
      }
    }
  }
</script>

<style scoped>

</style>
