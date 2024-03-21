<?php

namespace Database\Seeders;

use App\Models\Skills;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert Programming Languages
        Skills::create(['category' => 'Programming Languages', 'skill' => 'Java']);
        Skills::create(['category' => 'Programming Languages', 'skill' => 'Python']);
        Skills::create(['category' => 'Programming Languages', 'skill' => 'C/C++']);
        Skills::create(['category' => 'Programming Languages', 'skill' => 'C#']);
        Skills::create(['category' => 'Programming Languages', 'skill' => 'JavaScript']);
        Skills::create(['category' => 'Programming Languages', 'skill' => 'Ruby']);
        Skills::create(['category' => 'Programming Languages', 'skill' => 'PHP']);
        Skills::create(['category' => 'Programming Languages', 'skill' => 'Swift']);
        Skills::create(['category' => 'Programming Languages', 'skill' => 'Kotlin']);
        Skills::create(['category' => 'Programming Languages', 'skill' => 'TypeScript']);

        // Insert Web Development
        Skills::create(['category' => 'Web Development', 'skill' => 'HTML']);
        Skills::create(['category' => 'Web Development', 'skill' => 'CSS']);
        Skills::create(['category' => 'Web Development', 'skill' => 'JavaScript']);
        Skills::create(['category' => 'Web Development', 'skill' => 'Bootstrap']);
        Skills::create(['category' => 'Web Development', 'skill' => 'jQuery']);
        Skills::create(['category' => 'Web Development', 'skill' => 'Angular']);
        Skills::create(['category' => 'Web Development', 'skill' => 'React']);
        Skills::create(['category' => 'Web Development', 'skill' => 'Node.js']);
        Skills::create(['category' => 'Web Development', 'skill' => 'Express.js']);
        Skills::create(['category' => 'Web Development', 'skill' => 'RESTful APIs']);

        // Insert Database Management
        Skills::create(['category' => 'Database Management', 'skill' => 'SQL']);
        Skills::create(['category' => 'Database Management', 'skill' => 'MySQL']);
        Skills::create(['category' => 'Database Management', 'skill' => 'PostgreSQL']);
        Skills::create(['category' => 'Database Management', 'skill' => 'Oracle Database']);
        Skills::create(['category' => 'Database Management', 'skill' => 'Microsoft SQL Server']);
        Skills::create(['category' => 'Database Management', 'skill' => 'SQLite']);
        Skills::create(['category' => 'Database Management', 'skill' => 'MongoDB']);
        Skills::create(['category' => 'Database Management', 'skill' => 'Redis']);
        Skills::create(['category' => 'Database Management', 'skill' => 'Cassandra']);
        Skills::create(['category' => 'Database Management', 'skill' => 'Firebase']);

        // Insert Cloud Computing
        Skills::create(['category' => 'Cloud Computing', 'skill' => 'Amazon Web Services (AWS)']);
        Skills::create(['category' => 'Cloud Computing', 'skill' => 'Microsoft Azure']);
        Skills::create(['category' => 'Cloud Computing', 'skill' => 'Google Cloud Platform (GCP)']);
        Skills::create(['category' => 'Cloud Computing', 'skill' => 'IBM Cloud']);
        Skills::create(['category' => 'Cloud Computing', 'skill' => 'Oracle Cloud']);
        Skills::create(['category' => 'Cloud Computing', 'skill' => 'Cloud Foundry']);
        Skills::create(['category' => 'Cloud Computing', 'skill' => 'OpenStack']);
        Skills::create(['category' => 'Cloud Computing', 'skill' => 'VMware']);

        // Insert DevOps
        Skills::create(['category' => 'DevOps', 'skill' => 'Docker']);
        Skills::create(['category' => 'DevOps', 'skill' => 'Kubernetes']);
        Skills::create(['category' => 'DevOps', 'skill' => 'Jenkins']);
        Skills::create(['category' => 'DevOps', 'skill' => 'Ansible']);
        Skills::create(['category' => 'DevOps', 'skill' => 'Terraform']);
        Skills::create(['category' => 'DevOps', 'skill' => 'Git']);
        Skills::create(['category' => 'DevOps', 'skill' => 'GitHub']);
        Skills::create(['category' => 'DevOps', 'skill' => 'GitLab']);
        Skills::create(['category' => 'DevOps', 'skill' => 'Continuous Integration/Continuous Deployment (CI/CD)']);

        // Insert Cybersecurity
        Skills::create(['category' => 'Cybersecurity', 'skill' => 'Ethical Hacking']);
        Skills::create(['category' => 'Cybersecurity', 'skill' => 'Penetration Testing']);
        Skills::create(['category' => 'Cybersecurity', 'skill' => 'Security Operations']);
        Skills::create(['category' => 'Cybersecurity', 'skill' => 'Incident Response']);
        Skills::create(['category' => 'Cybersecurity', 'skill' => 'Security Information and Event Management (SIEM)']);
        Skills::create(['category' => 'Cybersecurity', 'skill' => 'Vulnerability Assessment']);
        Skills::create(['category' => 'Cybersecurity', 'skill' => 'Network Security']);
        Skills::create(['category' => 'Cybersecurity', 'skill' => 'Cryptography']);
        Skills::create(['category' => 'Cybersecurity', 'skill' => 'Security Compliance']);
        Skills::create(['category' => 'Cybersecurity', 'skill' => 'Data Science:']);
        Skills::create(['category' => 'Cybersecurity', 'skill' => 'Machine Learning']);
        Skills::create(['category' => 'Cybersecurity', 'skill' => 'Data Analysis']);
        Skills::create(['category' => 'Cybersecurity', 'skill' => 'Data Visualization']);
        Skills::create(['category' => 'Cybersecurity', 'skill' => 'Big Data Technologies (Hadoop, Spark)']);
        Skills::create(['category' => 'Cybersecurity', 'skill' => 'Natural Language Processing (NLP)']);
        Skills::create(['category' => 'Cybersecurity', 'skill' => 'Deep Learning']);
        Skills::create(['category' => 'Cybersecurity', 'skill' => 'Reinforcement Learning']);
        Skills::create(['category' => 'Cybersecurity', 'skill' => 'Predictive Analytics']);
        Skills::create(['category' => 'Cybersecurity', 'skill' => 'Statistical Modeling']);

        // Insert Artificial Intelligence
        Skills::create(['category' => 'Artificial Intelligence', 'skill' => 'Computer Vision']);
        Skills::create(['category' => 'Artificial Intelligence', 'skill' => 'Natural Language Processing (NLP)']);
        Skills::create(['category' => 'Artificial Intelligence', 'skill' => 'NLP)']);
        Skills::create(['category' => 'Artificial Intelligence', 'skill' => 'Robotics']);
        Skills::create(['category' => 'Artificial Intelligence', 'skill' => 'Expert Systems']);
        Skills::create(['category' => 'Artificial Intelligence', 'skill' => 'Speech Recognition']);
        Skills::create(['category' => 'Artificial Intelligence', 'skill' => 'AI Ethics']);
        Skills::create(['category' => 'Artificial Intelligence', 'skill' => 'Machine Learning']);

        // Insert Networking
        Skills::create(['category' => 'Networking', 'skill' => 'TCP/IP']);
        Skills::create(['category' => 'Networking', 'skill' => 'Routing']);
        Skills::create(['category' => 'Networking', 'skill' => 'Switching']);
        Skills::create(['category' => 'Networking', 'skill' => 'Network Security']);
        Skills::create(['category' => 'Networking', 'skill' => 'Wireless Networking']);
        Skills::create(['category' => 'Networking', 'skill' => 'Network Administration']);
        Skills::create(['category' => 'Networking', 'skill' => 'Software-Defined Networking (SDN)']);
        Skills::create(['category' => 'Networking', 'skill' => 'Network Virtualization']);

        // Insert Mobile Development
        Skills::create(['category' => 'Mobile Development', 'skill' => 'Android Development']);
        Skills::create(['category' => 'Mobile Development', 'skill' => 'iOS Development']);
        Skills::create(['category' => 'Mobile Development', 'skill' => 'Cross-Platform Development (React Native, Flutter)']);
        Skills::create(['category' => 'Mobile Development', 'skill' => 'Mobile UI/UX Design']);
        Skills::create(['category' => 'Mobile Development', 'skill' => 'Mobile App Testing']);
        Skills::create(['category' => 'Mobile Development', 'skill' => 'Mobile Security']);

        // Insert Embedded Systems
        Skills::create(['category' => 'Embedded Systems', 'skill' => 'C/C++ Programming for Embedded Systems']);
        Skills::create(['category' => 'Embedded Systems', 'skill' => 'Microcontroller Programming (Arduino, Raspberry Pi)']);
        Skills::create(['category' => 'Embedded Systems', 'skill' => 'Real-time Operating Systems (RTOS)']);
        Skills::create(['category' => 'Embedded Systems', 'skill' => 'Embedded Linux']);
        Skills::create(['category' => 'Embedded Systems', 'skill' => 'Hardware Description Languages (VHDL, Verilog)']);
        Skills::create(['category' => 'Embedded Systems', 'skill' => 'Firmware Development']);
        Skills::create(['category' => 'Embedded Systems', 'skill' => 'Embedded System Design']);
        Skills::create(['category' => 'Embedded Systems', 'skill' => 'Sensors and Actuators']);
        Skills::create(['category' => 'Embedded Systems', 'skill' => 'Internet of Things (IoT) Development']);
        Skills::create(['category' => 'Embedded Systems', 'skill' => 'Industrial Automation']);

        // Insert Oracle Fusion Financials Cloud
        Skills::create(['category' => 'Oracle Fusion Financials Cloud', 'skill' => 'General Ledger']);
        Skills::create(['category' => 'Oracle Fusion Financials Cloud', 'skill' => 'Accounts Payable']);
        Skills::create(['category' => 'Oracle Fusion Financials Cloud', 'skill' => 'Accounts Receivable']);
        Skills::create(['category' => 'Oracle Fusion Financials Cloud', 'skill' => 'Cash Management']);
        Skills::create(['category' => 'Oracle Fusion Financials Cloud', 'skill' => 'Expense Management']);
        Skills::create(['category' => 'Oracle Fusion Financials Cloud', 'skill' => 'Fixed Assets']);
        Skills::create(['category' => 'Oracle Fusion Financials Cloud', 'skill' => 'Financial Reporting']);

        // Insert Oracle Fusion Procurement Cloud
        Skills::create(['category' => 'Oracle Fusion Procurement Cloud', 'skill' => 'Procurement']);
        Skills::create(['category' => 'Oracle Fusion Procurement Cloud', 'skill' => 'Supplier Qualification Management']);
        Skills::create(['category' => 'Oracle Fusion Procurement Cloud', 'skill' => 'Sourcing']);
        Skills::create(['category' => 'Oracle Fusion Procurement Cloud', 'skill' => 'Purchasing']);
        Skills::create(['category' => 'Oracle Fusion Procurement Cloud', 'skill' => 'Supplier Portal']);
        Skills::create(['category' => 'Oracle Fusion Procurement Cloud', 'skill' => 'Procurement Contracts']);

        // Insert Oracle Fusion Supply Chain Management Cloud
        Skills::create(['category' => 'Oracle Fusion Supply Chain Management Cloud', 'skill' => 'Inventory Management']);
        Skills::create(['category' => 'Oracle Fusion Supply Chain Management Cloud', 'skill' => 'Cost Accounting']);
        Skills::create(['category' => 'Oracle Fusion Supply Chain Management Cloud', 'skill' => 'Order Management']);
        Skills::create(['category' => 'Oracle Fusion Supply Chain Management Cloud', 'skill' => 'Product Management']);
        Skills::create(['category' => 'Oracle Fusion Supply Chain Management Cloud', 'skill' => 'Maintenance']);
        Skills::create(['category' => 'Oracle Fusion Supply Chain Management Cloud', 'skill' => 'Quality']);
        Skills::create(['category' => 'Oracle Fusion Supply Chain Management Cloud', 'skill' => 'Manufacturing']);
        Skills::create(['category' => 'Oracle Fusion Supply Chain Management Cloud', 'skill' => 'Discrete']);
        Skills::create(['category' => 'Oracle Fusion Supply Chain Management Cloud', 'skill' => 'Process (OPM)']);
        Skills::create(['category' => 'Oracle Fusion Supply Chain Management Cloud', 'skill' => 'Supply Chain Planning']);
        Skills::create(['category' => 'Oracle Fusion Supply Chain Management Cloud', 'skill' => 'Supply Planning (SP)']);
        Skills::create(['category' => 'Oracle Fusion Supply Chain Management Cloud', 'skill' => 'Demand Planning (DM)']);
        Skills::create(['category' => 'Oracle Fusion Supply Chain Management Cloud', 'skill' => 'Replenishment Planning (RP)']);
        Skills::create(['category' => 'Oracle Fusion Supply Chain Management Cloud', 'skill' => 'Production Scheduling (PS)']);
        Skills::create(['category' => 'Oracle Fusion Supply Chain Management Cloud', 'skill' => 'Sales & Operation Planning (S&OP)']);
        Skills::create(['category' => 'Oracle Fusion Supply Chain Management Cloud', 'skill' => 'Order Backlog Management (OBM)']);
        Skills::create(['category' => 'Oracle Fusion Supply Chain Management Cloud', 'skill' => 'Global Order Promising (GOP)']);
        Skills::create(['category' => 'Oracle Fusion Supply Chain Management Cloud', 'skill' => 'Logistics']);

        // Insert Oracle Fusion Human Capital Management (HCM) Cloud
        Skills::create(['category' => 'Oracle Fusion Human Capital Management (HCM) Cloud', 'skill' => 'Core HR']);
        // Insert Oracle Fusion Human Capital Management (HCM) Cloud (continued)
        Skills::create(['category' => 'Oracle Fusion Human Capital Management (HCM) Cloud', 'skill' => 'Core HR']);
        Skills::create(['category' => 'Oracle Fusion Human Capital Management (HCM) Cloud', 'skill' => 'Payroll']);
        Skills::create(['category' => 'Oracle Fusion Human Capital Management (HCM) Cloud', 'skill' => 'Benefits']);
        Skills::create(['category' => 'Oracle Fusion Human Capital Management (HCM) Cloud', 'skill' => 'Talent Management']);
        Skills::create(['category' => 'Oracle Fusion Human Capital Management (HCM) Cloud', 'skill' => 'Performance Management']);
        Skills::create(['category' => 'Oracle Fusion Human Capital Management (HCM) Cloud', 'skill' => 'Workforce Management']);
        Skills::create(['category' => 'Oracle Fusion Human Capital Management (HCM) Cloud', 'skill' => 'HR Analytics']);

        // Insert Oracle Fusion Customer Experience (CX) Cloud
        Skills::create(['category' => 'Oracle Fusion Customer Experience (CX) Cloud', 'skill' => 'Sales']);
        Skills::create(['category' => 'Oracle Fusion Customer Experience (CX) Cloud', 'skill' => 'Service']);
        Skills::create(['category' => 'Oracle Fusion Customer Experience (CX) Cloud', 'skill' => 'Marketing']);
        Skills::create(['category' => 'Oracle Fusion Customer Experience (CX) Cloud', 'skill' => 'Commerce']);
        Skills::create(['category' => 'Oracle Fusion Customer Experience (CX) Cloud', 'skill' => 'Social']);

        // Insert Oracle Fusion Enterprise Resource Planning (ERP) Cloud
        Skills::create(['category' => 'Oracle Fusion Enterprise Resource Planning (ERP) Cloud', 'skill' => 'Financial Management']);
        Skills::create(['category' => 'Oracle Fusion Enterprise Resource Planning (ERP) Cloud', 'skill' => 'Procurement']);
        Skills::create(['category' => 'Oracle Fusion Enterprise Resource Planning (ERP) Cloud', 'skill' => 'Project Portfolio Management']);
        Skills::create(['category' => 'Oracle Fusion Enterprise Resource Planning (ERP) Cloud', 'skill' => 'Risk Management']);
        Skills::create(['category' => 'Oracle Fusion Enterprise Resource Planning (ERP) Cloud', 'skill' => 'Governance, Risk, and Compliance']);

        // Insert Oracle Fusion Project Portfolio Management (PPM) Cloud
        Skills::create(['category' => 'Oracle Fusion Project Portfolio Management (PPM) Cloud', 'skill' => 'Project Planning and Management']);
        Skills::create(['category' => 'Oracle Fusion Project Portfolio Management (PPM) Cloud', 'skill' => 'Project Cost Management']);
        Skills::create(['category' => 'Oracle Fusion Project Portfolio Management (PPM) Cloud', 'skill' => 'Project Resource Management']);
        Skills::create(['category' => 'Oracle Fusion Project Portfolio Management (PPM) Cloud', 'skill' => 'Project Billing and Contracts']);
        Skills::create(['category' => 'Oracle Fusion Project Portfolio Management (PPM) Cloud', 'skill' => 'Project Portfolio Analytics']);

        // Insert Oracle Fusion Enterprise Performance Management (EPM) Cloud
        Skills::create(['category' => 'Oracle Fusion Enterprise Performance Management (EPM) Cloud', 'skill' => 'Financial Consolidation and Close']);
        Skills::create(['category' => 'Oracle Fusion Enterprise Performance Management (EPM) Cloud', 'skill' => 'Planning and Budgeting']);
        Skills::create(['category' => 'Oracle Fusion Enterprise Performance Management (EPM) Cloud', 'skill' => 'Profitability and Cost Management']);
        Skills::create(['category' => 'Oracle Fusion Enterprise Performance Management (EPM) Cloud', 'skill' => 'Account Reconciliation']);
        Skills::create(['category' => 'Oracle Fusion Enterprise Performance Management (EPM) Cloud', 'skill' => 'Enterprise Data Management']);

        // Insert Oracle Fusion Analytics Cloud
        Skills::create(['category' => 'Oracle Fusion Analytics Cloud', 'skill' => 'Business Intelligence']);
        Skills::create(['category' => 'Oracle Fusion Analytics Cloud', 'skill' => 'Data Visualization']);
        Skills::create(['category' => 'Oracle Fusion Analytics Cloud', 'skill' => 'Self-Service Analytics']);
        Skills::create(['category' => 'Oracle Fusion Analytics Cloud', 'skill' => 'Predictive Analytics']);
        Skills::create(['category' => 'Oracle Fusion Analytics Cloud', 'skill' => 'Mobile Analytics']);

        // Insert Oracle Fusion Integration Cloud
        Skills::create(['category' => 'Oracle Fusion Integration Cloud', 'skill' => 'Application Integration']);
        Skills::create(['category' => 'Oracle Fusion Integration Cloud', 'skill' => 'Process Automation']);
        Skills::create(['category' => 'Oracle Fusion Integration Cloud', 'skill' => 'Data Integration']);
        Skills::create(['category' => 'Oracle Fusion Integration Cloud', 'skill' => 'API Management']);

        // Insert Financial Management
        Skills::create(['category' => 'Financial Management', 'skill' => 'General Ledger']);
        Skills::create(['category' => 'Financial Management', 'skill' => 'Accounts Payable']);
        Skills::create(['category' => 'Financial Management', 'skill' => 'Accounts Receivable']);
        Skills::create(['category' => 'Financial Management', 'skill' => 'Cash Management']);
        Skills::create(['category' => 'Financial Management', 'skill' => 'Fixed Assets']);
        Skills::create(['category' => 'Financial Management', 'skill' => 'Tax Management']);
        Skills::create(['category' => 'Financial Management', 'skill' => 'Expenses']);

        // Insert Procurement
        Skills::create(['category' => 'Procurement', 'skill' => 'Procurement']);
        Skills::create(['category' => 'Procurement', 'skill' => 'Self-Service Procurement']);
        Skills::create(['category' => 'Procurement', 'skill' => 'Sourcing']);
        Skills::create(['category' => 'Procurement', 'skill' => 'Supplier Portal']);
        Skills::create(['category' => 'Procurement', 'skill' => 'Procurement Contracts']);
        Skills::create(['category' => 'Procurement', 'skill' => 'Supplier Qualification Management']);

        // Insert Project Portfolio Management (PPM)
        Skills::create(['category' => 'Project Portfolio Management (PPM)', 'skill' => 'Project Costing']);
        Skills::create(['category' => 'Project Portfolio Management (PPM)', 'skill' => 'Project Billing']);
        Skills::create(['category' => 'Project Portfolio Management (PPM)', 'skill' => 'Project Management']);
        Skills::create(['category' => 'Project Portfolio Management (PPM)', 'skill' => 'Project Resource Management']);
        Skills::create(['category' => 'Project Portfolio Management (PPM)', 'skill' => 'Project Contracts and Grants Management']);

        // Insert Risk Management and Compliance
        Skills::create(['category' => 'Risk Management and Compliance', 'skill' => 'Risk Management']);
        Skills::create(['category' => 'Risk Management and Compliance', 'skill' => 'Internal Controls']);
        Skills::create(['category' => 'Risk Management and Compliance', 'skill' => 'Advanced Access Controls']);

        // Insert Supply Chain Management
        Skills::create(['category' => 'Supply Chain Management', 'skill' => 'Inventory Management']);
        Skills::create(['category' => 'Supply Chain Management', 'skill' => 'Order Management']);
        Skills::create(['category' => 'Supply Chain Management', 'skill' => 'Product Management']);
        Skills::create(['category' => 'Supply Chain Management', 'skill' => 'Manufacturing']);
        Skills::create(['category' => 'Supply Chain Management', 'skill' => 'Discrete']);
        Skills::create(['category' => 'Supply Chain Management', 'skill' => 'OPM (Process Mfg)']);
        Skills::create(['category' => 'Supply Chain Management', 'skill' => 'Maintenance']);
        Skills::create(['category' => 'Supply Chain Management', 'skill' => 'MRP Planning']);
        Skills::create(['category' => 'Supply Chain Management', 'skill' => 'Quality']);
        Skills::create(['category' => 'Supply Chain Management', 'skill' => 'Logistics']);
        Skills::create(['category' => 'Supply Chain Management', 'skill' => 'Value Chain Planning']);
        Skills::create(['category' => 'Supply Chain Management', 'skill' => 'Advanced Supply Chain Planning (ASC)']);
        Skills::create(['category' => 'Supply Chain Management', 'skill' => 'Demantra']);
        Skills::create(['category' => 'Supply Chain Management', 'skill' => 'Production Scheduling (PS)']);
        Skills::create(['category' => 'Supply Chain Management', 'skill' => 'Inventory Optimization (IO)']);
        Skills::create(['category' => 'Supply Chain Management', 'skill' => 'Global order Promising (GOP)']);
        Skills::create(['category' => 'Supply Chain Management', 'skill' => 'Distribution Planning (DRP)']);
        Skills::create(['category' => 'Supply Chain Management', 'skill' => 'Spare Parts Planning (SPP)']);
        Skills::create(['category' => 'Supply Chain Management', 'skill' => 'Advanced Planning Command Center (APCC)']);

        // Insert Enterprise Performance Management (EPM)
        Skills::create(['category' => 'Enterprise Performance Management (EPM)', 'skill' => 'Planning and Budgeting']);
        Skills::create(['category' => 'Enterprise Performance Management (EPM)', 'skill' => 'Financial Consolidation and Close']);
        Skills::create(['category' => 'Enterprise Performance Management (EPM)', 'skill' => 'Profitability and Cost Management']);
        Skills::create(['category' => 'Enterprise Performance Management (EPM)', 'skill' => 'Account Reconciliation']);
        Skills::create(['category' => 'Enterprise Performance Management (EPM)', 'skill' => 'Enterprise Data Management']);

        // Insert Revenue Management
        Skills::create(['category' => 'Revenue Management', 'skill' => 'Revenue Management']);
        Skills::create(['category' => 'Revenue Management', 'skill' => 'Advanced Collections']);
        Skills::create(['category' => 'Revenue Management', 'skill' => 'Billing and Revenue Management']);

        // Insert Reporting and Analytics
        Skills::create(['category' => 'Reporting and Analytics', 'skill' => 'Financial Reporting']);
        Skills::create(['category' => 'Reporting and Analytics', 'skill' => 'Embedded Analytics']);
        Skills::create(['category' => 'Reporting and Analytics', 'skill' => 'Real-Time Reporting']);
        Skills::create(['category' => 'Reporting and Analytics', 'skill' => 'Ad Hoc Analysis']);

        // Insert Integration and Data Management
        Skills::create(['category' => 'Integration and Data Management', 'skill' => 'Application Integration']);
        Skills::create(['category' => 'Integration and Data Management', 'skill' => 'Data Integration']);
        Skills::create(['category' => 'Integration and Data Management', 'skill' => 'Master Data Management']);
        Skills::create(['category' => 'Integration and Data Management', 'skill' => 'Data Quality Management']);

        // Insert Security and Compliance
        Skills::create(['category' => 'Security and Compliance', 'skill' => 'Security Management']);
        Skills::create(['category' => 'Security and Compliance', 'skill' => 'Audit and Compliance Reporting']);
        Skills::create(['category' => 'Security and Compliance', 'skill' => 'Segregation of Duties Controls']);

        // Insert Integration Technologies
        Skills::create(['category' => 'Integration Technologies', 'skill' => 'Application Programming Interfaces (APIs)']);
        Skills::create(['category' => 'Integration Technologies', 'skill' => 'Representational State Transfer (REST)']);
        Skills::create(['category' => 'Integration Technologies', 'skill' => 'Simple Object Access Protocol (SOAP)']);
        Skills::create(['category' => 'Integration Technologies', 'skill' => 'Web Services Description Language (WSDL)']);
        Skills::create(['category' => 'Integration Technologies', 'skill' => 'XML Schema Definition (XSD)']);
        Skills::create(['category' => 'Integration Technologies', 'skill' => 'JSON Schema']);
        Skills::create(['category' => 'Integration Technologies', 'skill' => 'Message Queueing Telemetry Transport (MQTT)']);
        Skills::create(['category' => 'Integration Technologies', 'skill' => 'Advanced Message Queuing Protocol (AMQP)']);
        Skills::create(['category' => 'Integration Technologies', 'skill' => 'Java Message Service (JMS)']);
        Skills::create(['category' => 'Integration Technologies', 'skill' => 'Enterprise Service Bus (ESB)']);
        Skills::create(['category' => 'Integration Technologies', 'skill' => 'Remote Procedure Call (RPC)']);
        Skills::create(['category' => 'Integration Technologies', 'skill' => 'Service-Oriented Architecture (SOA)']);
        Skills::create(['category' => 'Integration Technologies', 'skill' => 'Microservices Architecture']);

        // Insert Integration Tools
        Skills::create(['category' => 'Integration Tools', 'skill' => 'MuleSoft Anypoint Platform']);
        Skills::create(['category' => 'Integration Tools', 'skill' => 'Apache Camel']);
        Skills::create(['category' => 'Integration Tools', 'skill' => 'Apache Kafka']);
        Skills::create(['category' => 'Integration Tools', 'skill' => 'IBM Integration Bus (IIB)']);
        Skills::create(['category' => 'Integration Tools', 'skill' => 'Microsoft BizTalk Server']);
        Skills::create(['category' => 'Integration Tools', 'skill' => 'Dell Boomi']);
        Skills::create(['category' => 'Integration Tools', 'skill' => 'TIBCO BusinessWorks']);
        Skills::create(['category' => 'Integration Tools', 'skill' => 'Oracle Integration Cloud (OIC)']);
        Skills::create(['category' => 'Integration Tools', 'skill' => 'Informatica Intelligent Cloud Services']);
        Skills::create(['category' => 'Integration Tools', 'skill' => 'Jitterbit Harmony']);

        // Insert Data Integration
        Skills::create(['category' => 'Data Integration', 'skill' => 'Extract, Transform, Load (ETL) Tools (e.g., Informatica PowerCenter, Talend)']);
        Skills::create(['category' => 'Data Integration', 'skill' => 'Data Replication']);
        Skills::create(['category' => 'Data Integration', 'skill' => 'Change Data Capture (CDC)']);
        Skills::create(['category' => 'Data Integration', 'skill' => 'Data Mapping and Transformation']);
        Skills::create(['category' => 'Data Integration', 'skill' => 'Data Quality Management']);

        // Insert Cloud Integration
        Skills::create(['category' => 'Cloud Integration', 'skill' => 'Cloud-to-Cloud Integration']);
        Skills::create(['category' => 'Cloud Integration', 'skill' => 'On-Premises to Cloud Integration']);
        Skills::create(['category' => 'Cloud Integration', 'skill' => 'Hybrid Cloud Integration']);

        // Insert Security and Compliance
        Skills::create(['category' => 'Security and Compliance', 'skill' => 'Secure Sockets Layer (SSL)']);
        Skills::create(['category' => 'Security and Compliance', 'skill' => 'Transport Layer Security (TLS)']);
        Skills::create(['category' => 'Security and Compliance', 'skill' => 'OAuth']);
        Skills::create(['category' => 'Security and Compliance', 'skill' => 'OpenID Connect']);
        Skills::create(['category' => 'Security and Compliance', 'skill' => 'Single Sign-On (SSO)']);
        Skills::create(['category' => 'Security and Compliance', 'skill' => 'Role-Based Access Control (RBAC)']);
        Skills::create(['category' => 'Security and Compliance', 'skill' => 'Data Encryption']);
        Skills::create(['category' => 'Security and Compliance', 'skill' => 'Compliance Standards (e.g., GDPR, HIPAA)']);

        // Insert Monitoring and Management
        Skills::create(['category' => 'Monitoring and Management', 'skill' => 'Integration Monitoring Tools']);
        Skills::create(['category' => 'Monitoring and Management', 'skill' => 'Performance Monitoring']);
        Skills::create(['category' => 'Monitoring and Management', 'skill' => 'Error Handling and Logging']);
        Skills::create(['category' => 'Monitoring and Management', 'skill' => 'Scalability and Reliability']);

        // Insert Emerging Technologies in Integrations
        Skills::create(['category' => 'Emerging Technologies in Integrations', 'skill' => 'Internet of Things (IoT) Integration']);
        Skills::create(['category' => 'Emerging Technologies in Integrations', 'skill' => 'Artificial Intelligence (AI) and Machine Learning (ML) Integration']);
        Skills::create(['category' => 'Emerging Technologies in Integrations', 'skill' => 'Blockchain Integration']);

        // Insert Industry-Specific Integration Skills
        Skills::create(['category' => 'Industry-Specific Integration Skills', 'skill' => 'Healthcare Integration']);
        Skills::create(['category' => 'Industry-Specific Integration Skills', 'skill' => 'Financial Services Integration']);
        Skills::create(['category' => 'Industry-Specific Integration Skills', 'skill' => 'Retail Integration']);
        Skills::create(['category' => 'Industry-Specific Integration Skills', 'skill' => 'Manufacturing Integration']);
        Skills::create(['category' => 'Industry-Specific Integration Skills', 'skill' => 'Telecommunications Integration']);

        // Insert O9 Supply Chain Planning and Optimization
        Skills::create(['category' => 'O9 Supply Chain Planning and Optimization', 'skill' => 'Demand Planning']);
        Skills::create(['category' => 'O9 Supply Chain Planning and Optimization', 'skill' => 'Supply Planning']);
        Skills::create(['category' => 'O9 Supply Chain Planning and Optimization', 'skill' => 'Inventory Optimization']);
        Skills::create(['category' => 'O9 Supply Chain Planning and Optimization', 'skill' => 'Sales and Operations Planning (S&OP)']);
        Skills::create(['category' => 'O9 Supply Chain Planning and Optimization', 'skill' => 'Supply Chain Network Design']);
        Skills::create(['category' => 'O9 Supply Chain Planning and Optimization', 'skill' => 'Multi-Echelon Inventory Optimization (MEIO)']);
        Skills::create(['category' => 'O9 Supply Chain Planning and Optimization', 'skill' => 'Capacity Planning']);
        Skills::create(['category' => 'O9 Supply Chain Planning and Optimization', 'skill' => 'Production Planning and Scheduling']);
        Skills::create(['category' => 'O9 Supply Chain Planning and Optimization', 'skill' => 'Distribution Planning']);
        Skills::create(['category' => 'O9 Supply Chain Planning and Optimization', 'skill' => 'Order Promising and Fulfillment']);
        Skills::create(['category' => 'O9 Supply Chain Planning and Optimization', 'skill' => 'Supply Chain Analytics']);

        // Insert O9 Platform Skills
        Skills::create(['category' => 'O9 Platform Skills', 'skill' => 'O9 Platform Configuration']);
        Skills::create(['category' => 'O9 Platform Skills', 'skill' => 'O9 Platform Administration']);
        Skills::create(['category' => 'O9 Platform Skills', 'skill' => 'O9 Data Model Understanding']);
        Skills::create(['category' => 'O9 Platform Skills', 'skill' => 'O9 Integration Capabilities']);
        Skills::create(['category' => 'O9 Platform Skills', 'skill' => 'O9 Workflow Management']);
        Skills::create(['category' => 'O9 Platform Skills', 'skill' => 'O9 Scenario Planning and Simulation']);
    }
}
