CREATE TABLE mahasiswa (
    nim			varchar(10) NOT NULL,
    nama		varchar(255) NOT NULL,
    angkatan	int(11) NOT NULL,
    semester	int(11) NOT NULL,
    ipk			double NOT NULL,
    PRIMARY KEY(nim)
)