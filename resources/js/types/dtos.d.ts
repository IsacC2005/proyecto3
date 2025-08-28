export type Grade = 1 | 2 | 3 | 4 | 5 | 6;

export interface Representative {
    id: number,
    idcard: number,
    phone: number,
    name: string,
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
    students: Student[],
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
}

export interface Teacher {
    id: number,
    name: string,
    surname: string,
    user: User,
}

export interface User {
    id: number,
    name: string,
    email: string,
    password: string,
}
