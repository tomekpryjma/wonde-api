<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1>Upcoming lessons</h1>
            </div>
        </div>
        <div class="row">
            <div v-for="cls in employee.classes.data">

                <button class="btn class-button btn-primary" type="button" data-bs-toggle="collapse"
                    :data-bs-target="`#accordion-${cls.id}`" aria-expanded="false"
                    :aria-controls="`accordion-${cls.id}`">
                    Class <strong>{{ cls.name }}</strong>
                </button>

                <div class="collapse" :id="`accordion-${cls.id}`">
                    <div class="card card-body">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <h4>When and Where?</h4>

                                <ul v-if="cls.lessons.data.length">
                                    <li v-for="lesson in cls.lessons.data">
                                        {{ formatDate(lesson.start_at.date) }} in the {{ lesson.room.data.name }}
                                    </li>
                                </ul>
                            </div>

                            <div class="col-12">
                                <span v-if="students[cls.id]">
                                    <h4>Students</h4>

                                    <ul>
                                        <li v-for="student in students[cls.id]">
                                            {{ studentName(student) }}
                                        </li>
                                    </ul>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import moment from 'moment';
import Vue from 'vue';

export default {
    props: ['employeeId', 'schoolId', 'token', 'apiUrl'],
    data() {
        return {
            students: {},
            employee: null,
            url: `${this.apiUrl}/schools/${this.schoolId}`,
        }
    },
    mounted() {
        const self = this;
        const auth = {
            'Authorization': `Bearer: ${this.token}`
        }

        axios.get(this.url + '/employees/' + this.employeeId + '?include=classes,classes.lessons,classes.lessons.room', {
            headers: auth,
            params: {
                lessons_start_after: moment().startOf('day').toISOString()
            }
        }).then(response => {
            let data = response.data.data;
            this.employee = data;

            return data;
        }).then(data => {
            for (let c of data.classes.data) {
                axios.get(this.url + '/classes/' + c.id + '?include=students', {
                    headers: auth
                }).then(classRes => {
                    const classData = classRes.data.data;
                    Vue.set(self.students, classData.id, classData.students.data)
                })
            }
        })
    },
    methods: {
        studentName: function (student) {
            let name = student.forename;

            if (student.middle_names) {
                name += ` ${student.middle_names}`;
            }

            name += ` ${student.surname}`;

            return name;
        },

        formatDate: function (date) {
            return moment(date).format('MMM. D, YYYY [at] h:mm A z');
        }
    }
}
</script>
