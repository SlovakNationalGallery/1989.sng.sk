<template>
  <div id="calendar" class="cldr">
    <!-- <transition name="slide">
      <months-view v-if="showCalendar" :days="days" @input="setDate($event)" />
    </transition> -->
    <div class="container">
      <div class="row">
        <div class="offset-lg-2 col-lg-8">
          <row-view ref="rowView" :days="days" :currentDate="currentDate" @change="setDate" />
        </div>
      </div>
    </div>
    <div class="container-fluid buttons row">
      <!-- <div class="offset-sm-2 col-sm-4 offset-md-3 col-md-3">
        <button
          class="btn btn-dark w-100"
          @click="showCalendar = !showCalendar"
        >
          Kalendár
        </button>
      </div> -->
      <div class="offset-sm-4 col-sm-4  offset-md-5 col-md-2">
        <button class="btn btn-outline-light w-100" @click="goToToday">
          Dnes
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import RowView from "./RowView";
import MonthsView from "./MonthsView";

import dayjs from "dayjs";
import utc from "dayjs/plugin/utc";
import "dayjs/locale/sk";
dayjs.extend(utc);
dayjs.locale("sk");
import weekOfYear from "dayjs/plugin/weekOfYear";

dayjs.extend(weekOfYear);

export default {
  name: "Calendar",
  components: { RowView, MonthsView },
  props: [
    "startDate",
    "endDate",
    "activeDatesStart",
    "activeDatesEnd",
    "today",
    "defaultDate"
  ],
  data() {
    return {
      showCalendar: false
    };
  },
  computed: {
    days() {
      const days = [];
      const end = dayjs(this.endDate);

      for (
        var day = dayjs(this.startDate);
        !day.isAfter(end);
        day = day.add(1, "day")
      ) {
        days.push({
          d: day.format("YYYY-MM-DD"),
          active:
            !day.isBefore(this.activeDatesStart) &&
            !day.isAfter(this.activeDatesEnd)
        });
      }

      return days
    },
    currentDate() {
      return _.get(this, '$route.params.date') || this.defaultDate
    }
  },
  methods: {
    setDate(date) {
      if (date !== _.get(this, "$route.params.date")) Router.push({ name: "days", params: { date } });
      this.showCalendar = false;
    },
    goToToday() {
      this.setDate(this.today)
      this.$refs.rowView.navigateToCurrentDate()
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss">
.cldr {
  position: relative;
  .buttons {
    margin: 1rem auto;
  }
}
.weekend {
  font-weight: bolder;
}

.cldr-months-wrapper {
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  z-index: 1000;
}
.cldr-week-wrapper {
  position: relative;
  text-align: left;
  background: rgba(255, 255, 255, 0.95);
}

.cldr-week {
  display: inline-block;
  text-align: right;
  width: 2em;
}

.cldr-days-wrapper {
  display: inline-block;
  margin-left: 2em;
}
.cldr-day-wrapper {
  display: inline-block;
  left: 1em;
  padding: 4px;
  width: 3em;
  line-height: 2em;
  cursor: pointer;
  text-align: center;
}
.cldr-day-wrapper.inactive {
  opacity: 0.4;
  pointer-events: none;
}
.cldr-day-wrapper.shaded {
  background: rgba(0, 0, 0, 0.1);
}
.cldr-day-wrapper:hover {
  background: rgba(0, 0, 0, 0.2);
}
.cldr-day {
  display: inline-block;
}
</style>
