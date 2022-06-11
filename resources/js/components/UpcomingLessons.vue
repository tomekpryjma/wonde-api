<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Upcoming lessons</div>
                </div>
            </div>
        </div>
        <div class="row">
            <ul>
                <li v-for="cls in employee.classes.data">
                    <strong>Class: </strong> {{ cls.name }}

                    <ul v-if="cls.lessons.data.length">
                        <li v-for="lesson in cls.lessons.data">
                            <strong>When: </strong>{{ formatDate(lesson.start_at.date) }}<br />
                            <strong>Where: </strong>{{ lesson.room.data.name }}
                        </li>

                        <span v-if="students[cls.id]">
                            <strong>Students:</strong>

                            <ul>
                                <li v-for="student in students[cls.id]">
                                    {{ studentName(student) }}
                                </li>
                            </ul>
                        </span>
                    </ul>
                </li>
            </ul>
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
            classes: [],
            lessons: [],
            students: {},
            employee: null,
            url: `${this.apiUrl}/schools/${this.schoolId}`,
        }
    },
    created() {
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
