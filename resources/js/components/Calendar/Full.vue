<template>
<div class="modal fade" :id="id" tabindex="-1" role="dialog" :aria-labelledby="`${id}-title`" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="navigation">
    <div class="modal-content">
      <div class="modal-header border-0">
        <div class="container-fluid">
          <div class="row">
            <div class="col-8 offset-2 pt-5">
              <h5 class="title text-center h3" :id="`${id}-title`">
                <strong>Kalendár</strong> 1989
                <small class="d-none d-lg-inline"><br/>{{ firstMonth }} &mdash; {{ lastMonth }}</small>
              </h5>
            </div>
            <div class="col-2 text-right pt-3">
              <button type="button" class="btn btn-sm btn-outline-dark px-0" data-dismiss="modal" aria-label="Zatvoriť">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-body pb-5">
        <!-- Smaller layout -->
        <div class="d-lg-none d-flex flex-column" v-for="month in months" :key="month[0]">
          <h3 class="month-name text-center pb-0"><small>{{ month[0] | formatMonth }}</small></h3>
          <div class="d-flex flex-row flex-wrap justify-content-center">
            <day
              v-for="day in month"
              color-coded
              class="m-1"
              :key="day"
              :date="day"
              :disabled="enabledDays.indexOf(day) === -1"
            ></day>
          </div>
        </div>

        <!-- Full-width layout -->
        <div class="d-none d-lg-inline-flex container-fluid flex-column">
          <div class="d-flex mx-auto" v-for="week in weeks" :key="week[0]">
            <div class="p-1" v-for="day in week" :key="day">
              <day
                v-if="isDayInRange(day)"
                color-coded
                :date="day"
                :disabled="enabledDays.indexOf(day) === -1"
              ></day>
              <div v-else class="day-filler"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
import dayjs from "dayjs"
import { chunk, groupBy } from "lodash"

import Day from "./Day"

const FIRST_DAY = dayjs("1989-09-01")
const LAST_DAY = dayjs("1989-12-31")

//  Generates a range of dates from FIRST_DAY until LAST_DAY,
//  starting on Monday and ending on Sunday
function calculateDays() {
  const start = FIRST_DAY.startOf('week')
  const end = LAST_DAY.endOf('week')

  return [
    ...Array(end.diff(start, 'days') + 1)
    ]
    .map((_, index) => start.clone().add(index, 'days').format("YYYY-MM-DD"))
}

export default {
  components: { Day },
  props: {
    id: {
      type: String,
      required: true,
    },
    enabledDays: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      days: calculateDays(),
    }
  },
  computed: {
    weeks() {
      return chunk(this.days, 7)
    },
    months() {
      return Object.values(
        groupBy(this.daysInRange, day => dayjs(day).month())
      )
    },
    firstMonth() {
      return FIRST_DAY.format("MMMM")
    },
    lastMonth() {
      return LAST_DAY.format("MMMM")
    },
    daysInRange() {
      return this.days.slice(
        this.days.indexOf(FIRST_DAY.format("YYYY-MM-DD")),
        this.days.indexOf(LAST_DAY.format("YYYY-MM-DD")),
      )
    }
  },
  methods: {
    isDayInRange(day) {
      const dayParsed = dayjs(day)
      return !dayParsed.isBefore(FIRST_DAY) && !dayParsed.isAfter(LAST_DAY)
    }
  },
  filters: {
    formatMonth(date) {
      return dayjs(date).format("MMMM")
    }
  }
};
</script>

<style lang="scss">
@import '~@/_variables.scss';

.day-filler {
  width: 3.9rem
}

.modal-header {
  & button {
    line-height: 1rem;
    font-size: 1.5rem;
    font-weight: bold;
    width: 2rem;
    height: 2rem;
  }
  & .title, .month-name {
    font-family: $font-family-base;
    font-weight: normal;
  }
}
</style>
