export type Pagination<T> = {
    data: T[],
    links: string[],
    total: number,
    currentPage: number,
    lastPage: number,
}

export type Grade = 1 | 2 | 3 | 4 | 5 | 6;

export interface Representative {
    id: number,
    idcard: number,
    phone: number,
    name: string,
    surname: string,
    direction: string
}

export interface Student {
    id: number,
    name: string,
    surname: string,
    grade: Grade,
}

export type SchoolYear = `${number}-${number}`;

export type SchoolMoment = 1 | 2 | 3;

export type SectionName = A | B | C | D | F | G | H | a | b | c | d | f | g | h;

export interface Section {
    id: number,
    students: Student[] | number[],
    teacher: Teacher | null,
    learningProject: LearningProject,
    schoolYear: SchoolYear,
    schoolMoment: SchoolMoment,
    grade: Grade,
    section: SectionName,
    classroom: string
}

export interface LearningProject {
    id: number,
    title: string,
    content: string,
    schoolMoment: 1 | 2 | 3,
    enrollment: Section | null,
    dailyClasses: DailyClass[]
}

export interface DailyClass {
    id: number,
    title: string,
    content: string,
    date: Date,
    indicators: Indicator[]
}

export interface Indicator {
    id: number,
    title: string
}

export interface Teacher {
    id: number,
    name: string,
    surname: string,
    phone: string,
    userId: int,
    user: User,
}

export interface User {
    id: number,
    name: string,
    email: string,
    password: string,
    roles: Role[]
}

export interface Role {
    id: number
    name: string
}

export interface ReportNote {
    id: number
    average: string
    content: string
    suggestions: string
    studentName: string
    studentSurName: string
    learningProjectId: number
    studentId: number
}
