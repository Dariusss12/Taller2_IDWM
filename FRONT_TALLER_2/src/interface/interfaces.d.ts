export interface User{
    id: number;
    name: string;
    lastname: string;
    id_number: string;
    email: string;
    points_earned: number;
}

export interface FormErrors {
    [key: string]: string;
};

export interface AdminCredentials {
    username: string;
    password: string;
}

export interface FormAddUser{
    name: string;
    lastname: string;
    id_number: string;
    email: string;
    points_earned: number;
}

export interface FormEditUser{
    name: string;
    lastname: string;
    email: string;
    points_earned: number;
}