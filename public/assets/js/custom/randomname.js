var adjectives = [
    "Muhammad", "Fatimah", "Ahmad", "Siti", "Abdullah", "Nur", "Ibrahim", "Laila", "Ali", "Isabella",
    "Aisyah", "Mustafa", "Zahra", "Hamid", "Rahma", "Hassan", "Alya", "Yusuf", "Khadijah",
    "Hussein", "Amina", "Omar", "Sara", "Khalid", "Aisha", "Yasin", "Hana", "Jamil", "Maryam",
    "Jafar", "Zainab", "Kareem", "Firdaus", "Salim", "Jasmine", "Musa", "Amira", "Kamil", "Lina",
    "Mahmoud", "Dina", "Imran", "Amani", "Rashid", "Samira", "Tariq", "Lubna", "Karim", "Nadia",
    "James", "Emma", "William", "Olivia", "Alexander", "Ava", "Michael", "Sophia", "Daniel",
    "Matthew", "Mia", "Joseph", "Emily", "David", "Charlotte", "John", "Amelia", "Christopher",
    "Ella", "Robert", "Grace", "Anthony", "Chloe", "Andrew", "Lily", "Joshua", "Madison", "Ryan",
    "Avery", "Samuel", "Abigail", "Benjamin", "Evelyn", "Nicholas", "Harper", "Jonathan", "Scarlett",
    "Tyler", "Sofia", "Gabriel", "Victoria", "Christian", "Anna", "Jonathan", "Lucas", "Nathan"];
var nouns = [
    "Smith", "Johnson", "Williams", "Jones", "Brown", "Davis", "Miller", "Wilson", "Moore", "Taylor",
    "Anderson", "Thomas", "Jackson", "White", "Harris", "Martin", "Thompson", "Garcia", "Martinez",
    "Robinson", "Clark", "Rodriguez", "Lewis", "Lee", "Walker", "Hall", "Allen", "Young", "Hernandez",
    "King", "Wright", "Lopez", "Hill", "Scott", "Green", "Adams", "Baker", "Gonzalez", "Nelson", "Carter",
    "Mitchell", "Perez", "Roberts", "Turner", "Phillips", "Campbell", "Parker", "Evans", "Santoso",
    "Siregar", "Purba", "Hidayat", "Saputra", "Kusuma", "Setiawan", "Pratama", "Gunawan", "Hartono",
    "Mulyono", "Budiman", "Pangestu", "Hadi", "Wibowo", "Santoso", "Wijaya", "Susanto", "Santoso", "Liem",
    "Budi", "Saputro", "Hermawan", "Kristanto", "Salim", "Kurniawan", "Wahyudi", "Putra", "Mahardika",
    "Nugroho", "Yulianto", "Utama", "Suryono", "Saputra", "Prasetyo", "Hermawan", "Firmansyah", "Wijaya",
    "Suryadi", "Sitorus", "Sihombing", "Budianto", "Wahono", "Fernando", "Anggara", "Purnama"];

function RandomName() {
    var adjective = adjectives[Math.floor(Math.random() * adjectives.length)];
    var noun = nouns[Math.floor(Math.random() * nouns.length)];
    return adjective + " " + noun;
}
