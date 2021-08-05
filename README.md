1. GET BALANCE FOR NON-EXISTING ACCOUNT
   GET / balance?account_id = 1234
   404 0

---

2. CREATE ACCOUNT WITH INITIAL BALANCE
   POST /event {"type":"deposit","destination":100,"amount":120}
   201 {"destination":{"id":100,"balance":10}}

---

3. DEPOSIT INTO EXISTING ACCOUNT
   POST / EVENT {"type":"deposit","destination":100,"amount":10}
   201 {"destination":{"id":100,"balance":20}}

---

4. WITHDRAW FROM ACCOUNT NON EXISTING ACCOUNT

POST / EVENT {"type:"withdraw,"origin":100,"amount":5}
404 0

5. WITHDRAW FROM EXISTING ACCOUNT

POST / EVENT {"type":widthdraw,"origin":100,"amount":5}
201 {"origin":{"id":100,"balance"15}}

6. TRANSFER EXISTING ACCOUNT

POST / EVENT {"type":"widthdraw,"origin":100,"amount":15,"destination":300}
201 {"origin": {"id":100,"balance":0, } "destination":{"id":300,"balance":15} }

7. TRANSFER NON EXISTING ACCOUNT
   POST / EVENT {"type":"widthdraw,"origin":1100,"amount":15,"destination":3300}
   404 0
