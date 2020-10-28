<template>
  <div class="p-10">
    <h3 class="font-bold text-base">Question ID #{{ question.id }}</h3>
    <div class="my-3">
      <div>
        <small class="float-right mb-3 hidden">Time Remaining : {{ time }}</small>
      </div>
      <hr class="my-3 clear-both" />
      <p class="text-lg">{{ question.text }}</p>
      <ul class="my-3">
        <li v-for="choice in question.choices"
            :key="choice.id">
          <input :type="question.type"
                 :id="'choice_' + choice.id"
                 :value="choice.id"
                 v-model="answers">
          <label :for="'choice_' + choice.id">{{ choice.text }}</label>
        </li>
      </ul>
      <div>
        <button
                @click="submit"
                class="my-3 float-right inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">next</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    props: {
      question: Object,
      qsession_id: Number
    },
  data() {
    return {
      answers: [],
      date: moment(60 * 2 * 1000),
    };
  },
  computed: {
    time: function () {
      return this.date.format("mm:ss");
    },
  },
  mounted: function () {
    this.timer(this.date);
  },
  methods: {
    timer: function (time) {
      let interval = setInterval(() => {
        this.date = moment(time.subtract(1, "seconds"));
      }, 1000);
      setTimeout(() => {
        clearInterval(interval);
        //this.submit();
      }, time);
    },
    submit: function () {
      let data = {
        question_id: this.question.id,
        answers: this.answers,
        qsession_id: this.qsession_id
      };
      this.$inertia.post('/answer', data)
      this.answers = [];
      this.date = moment(60 * 2 * 1000);
    },
  },
};
</script>
