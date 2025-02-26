*** Settings ***
Library    SeleniumLibrary

*** Variables ***
${URL}              http://127.0.0.1:8000/
${LOGIN_URL}        http://localhost:8000/login 
${BROWSER}          Chrome
${VALID_USER}       admin@gmail.com
${VALID_PASSWORD}   123456789
${CHROME_DRIVER_PATH}    /Users/ptpspp/Documents/GitHub/git-group-repository-group-4-sec-4/InitialProject/tests/robot_framework/chromedriver-mac-arm64/chromedriver

*** Test Cases ***
Login Test
    [Documentation]    ทดสอบการเข้าสู่ระบบด้วยชื่อผู้ใช้และรหัสผ่านที่ถูกต้อง
    Open Browser    ${URL}    ${BROWSER}    executable_path=${CHROME_DRIVER_PATH}
    Title Should Be    ระบบข้อมูลงานวิจัย วิทยาลัยการคอมพิวเตอร์
    
    # คลิกปุ่มเปลี่ยนภาษา
    Click Element    id=navbarDropdownMenuLink

    # เลือกตัวเลือกภาษาแรกใน dropdown โดยใช้ id
    Click Element    id=language-th  # แทนที่ด้วย id ของตัวเลือกภาษาแรกที่ต้องการ
    Sleep    2  # รอให้เว็บโหลดภาษาใหม่

    Click Element    id=btn-login
    Sleep    2  # รอให้เว็บโหลดภาษาใหม่

   # สลับไปยังแท็บใหม่ที่เปิดขึ้น
    ${window_handles} =    Get Window Handles
    Switch Window    ${window_handles}[1]  # เปลี่ยนไปที่แท็บใหม่ (แท็บที่สอง)

    # รอให้ฟิลด์กรอกชื่อผู้ใช้และรหัสผ่านปรากฏ
    Wait Until Element Is Visible    id=username    timeout=10s

    Input Username
    Input Password
    Click Submit Button
    Sleep    5  # รอให้เว็บโหลดภาษาใหม่

      # ตรวจสอบว่าข้อความเปลี่ยนไปถูกต้อง
    ${translated_text}=    Get Text    id=title-dashboard-admin
    ${expected_text}=    Set Variable    ยินดีต้อนรับเข้าสู่ระบบจัดการข้อมูลวิจัยของสาขาวิชาวิทยาการคอมพิวเตอร์  # ข้อความที่ควรเป็นหลังจากเปลี่ยนภาษา

    Should Be Equal    ${translated_text}    ${expected_text}    Test Failed! Expected '${expected_text}', but got '${translated_text}'

    Close Browser

*** Keywords ***
Input Username
    [Documentation]    กรอกชื่อผู้ใช้ที่ช่อง username
    Input Text    id=username    ${VALID_USER}

Input Password
    [Documentation]    กรอกรหัสผ่านที่ช่อง password
    Input Text    id=password    ${VALID_PASSWORD}

Click Submit Button
    [Documentation]    คลิกปุ่มส่งข้อมูล
    Click Button    id=submit


