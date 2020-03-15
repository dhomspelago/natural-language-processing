<template>
  <div class="custom-wrapper">
    <div class="d-flex justify-content-center">
      <p class="heading-text text-uppercase">Natural Language Processing</p>
    </div>
    <div class="content">
      <div class="d-flex justify-content-center mb-3">
        <textarea class="text-area w-100 p-4" rows="10" v-model="text"></textarea>
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

    <div v-if="resultBool">
      <h3>Result:</h3>
      <div class="result">
        <div v-if="type === 'summarize'"
             class="p-4">
          <p v-for="data in summarize">
            {{ data }}
          </p>
        </div>
        <div v-if="type === 'sentiment'" class="d-flex p-4 align-items-center justify-content-center h-100">
          <div class="justify-content-start positive">
            <div class="d-flex justify-content-center ">
              <h2>{{ sentimentResult.pos }}</h2>
            </div>
            <h3>Positive</h3>
          </div>
          <div class="justify-content-center px-5 neutral">
            <div class="d-flex justify-content-center">
              <h2>{{ sentimentResult.neu }}</h2>
            </div>
            <h3>Neutral</h3>
          </div>
          <div class="justify-content-end negative">
            <div class="d-flex justify-content-center ">
              <h2>{{ sentimentResult.neg }}</h2>
            </div>
            <h3>Negative</h3>
          </div>
        </div>
        <div v-if="type === 'language'" class="p-4 language">
          <p>{{ languageResult }}</p>
        </div>
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
        resultBool: false,
        summarize: '',
        languageResult: '',
        sentimentResult: ''
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
        switch (this.type) {
          case 'summarize':
            this.summarize = response.data
            return this.summarize
          case 'sentiment':
            return this.sentimentResult = response.data
          case 'language':
            return this.languageResult = response.data
        }
      },
    }
  }
</script>

<style scoped>
  .positive h2, .positive h3 {
    color: #227e35 !important;
  }

  .neutral h2, .neutral h3 {
    color: #ffdf00 !important;
  }

  .negative h2, .negative h3 {
    color: #8b0000 !important;
  }

  .language p {
    font-size: 2rem;
  }
</style>
